<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\DasarHukum;
use App\Models\Klasifikasi;
use App\Models\Jenis;
use App\Models\LogStatusDokumen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Carbon\Carbon;

class ArsipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $perPage = (int) $request->input('perPage', 5);

        $query = Arsip::with('user')
            ->join('users', 'arsip.dibuat_oleh', '=', 'users.id')
            ->select('arsip.*', 'users.nama_user as nama_tim_kerja');

        // Filter berdasarkan role
        if (in_array($request->user()->role, [1, 2, 3])) {
            // Admin/pimpinan/kepala melihat semua arsip aktif atau terverifikasi
            $query->where(function ($q) {
                $q->where('arsip.status_dokumen', 'Aktif')
                    ->orWhere('arsip.verifikasi_arsip', 'Verifikasi');
            });
        } else {
            // User biasa hanya bisa melihat arsipnya sendiri dengan status tertentu
            $query->where(function ($q) {
                $q->where(function ($sub) {
                    $sub->where('arsip.status_dokumen', 'Aktif')
                        ->orWhere('arsip.verifikasi_arsip', 'Verifikasi');
                })->where('arsip.dibuat_oleh', Auth::id());
            });
        }

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_dokumen', 'like', '%' . $search . '%')
                    ->orWhere('kode_dokumen', 'like', '%' . $search . '%')
                    ->orWhere('users.nama_user', 'like', '%' . $search . '%');
            });
        }

        // Filter tanggal
        if ($request->filled('range')) {
            $range = explode(' to ', $request->input('range'));
            if (count($range) === 2) {
                try {
                    $start = Carbon::createFromFormat('d-m-Y', trim($range[0]))->startOfDay();
                    $end = Carbon::createFromFormat('d-m-Y', trim($range[1]))->endOfDay();
                    $query->whereBetween('batas_status_retensi_aktif', [$start, $end]);
                } catch (\Exception $e) {
                    // Format salah, abaikan filter
                }
            }
        }


        // Ambil arah sorting dari query param 'sort', default ke 'desc' biar sama seperti sebelumnya
        $sort = strtolower($request->input('sort', 'desc'));
        if (!in_array($sort, ['asc', 'desc'])) {
            $sort = 'desc';
        }

        // Sorting berdasarkan tanggal_arsip sesuai param sort
        $query->orderBy('tanggal_arsip', $sort);

        // Pagination
        $arsip = $query->paginate($perPage)->withQueryString();

        return view('arsip.index', compact('arsip'))
            ->with('i', ($request->input('page', 1) - 1) * $perPage);

        // Ambil arah sorting dan kolom sorting dari query param
        $sortColumn = $request->input('sort_by', 'tanggal_arsip');
        $sortDirection = strtolower($request->input('sort', 'desc'));
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        // Validasi kolom sorting agar tidak disalahgunakan
        $allowedSorts = ['tanggal_arsip', 'nama_dokumen', 'nama_tim_kerja'];
        if (!in_array($sortColumn, $allowedSorts)) {
            $sortColumn = 'tanggal_arsip';
        }

        // Terapkan sorting
        $query->orderBy($sortColumn, $sortDirection);
    }




    public function create()
    {
        $klasifikasi = Klasifikasi::all();
        $dasar_hukum = DasarHukum::select('id_dasar_hukum', 'nama_dasar_hukum')->orderBy('nama_dasar_hukum')->get();
        return view('arsip.create', compact('klasifikasi', 'dasar_hukum'));
    }

    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'nama_dokumen'       => 'required|string|max:255',
            'dasar_hukum'        => 'required|exists:dasar_hukum,id_dasar_hukum',
            'klasifikasi'        => 'required|exists:klasifikasi,id_klasifikasi',
            'tanggal_arsip'      => 'required|date',
            'arsip_dokumen'      => 'required|array',
            'arsip_dokumen.*'    => 'file|mimes:pdf|max:5120',
        ], [
            'nama_dokumen.required'          => 'Nama dokumen tidak boleh kosong.',
            'dasar_hukum.required'           => 'Pilih dasar hukum.',
            'klasifikasi.required'           => 'Pilih klasifikasi.',
            'tanggal_arsip.required'         => 'Tanggal arsip wajib diisi.',
            'tanggal_arsip.date'             => 'Format tanggal arsip tidak valid.',
            'arsip_dokumen.required'         => 'Wajib unggah minimal satu dokumen.',
            'arsip_dokumen.array'            => 'Dokumen harus dikirim sebagai array.',
            'arsip_dokumen.*.file'           => 'Setiap file harus berupa dokumen.',
            'arsip_dokumen.*.mimes'          => 'File harus dalam format PDF.',
            'arsip_dokumen.*.max'            => 'Ukuran file maksimal 5MB.',
        ]);

        // Ambil data klasifikasi dan format kode dokumen
        $klasifikasi = Klasifikasi::find($request->klasifikasi);
        $kodeKlasifikasi = $klasifikasi ? $klasifikasi->kode_klasifikasi : 'XXX';
        $tahun = date('Y', strtotime($request->tanggal_arsip));

        $jumlahArsipTahunIni = Arsip::whereYear('tanggal_arsip', $request->tanggal_arsip)->count();
        $nomorUrut = str_pad($jumlahArsipTahunIni + 1, 3, '0', STR_PAD_LEFT);

        $kodeDokumen = $kodeKlasifikasi . '/' . $tahun . '/' . $nomorUrut;

        // Upload file PDF dan simpan nama file
        $fileNames = [];
        foreach ($request->file('arsip_dokumen') as $file) {
            $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/dokumen', $filename);
            $fileNames[] = $filename;
        }

        // Simpan ke database
        Arsip::create([
            'kode_dokumen' => $kodeDokumen,
            'nama_dokumen' => $request->nama_dokumen,
            'tanggal_arsip' => $request->tanggal_arsip,
            'deskripsi_arsip' => $request->deskripsi_arsip,
            'dasar_hukum' => $request->dasar_hukum,
            'klasifikasi' => $request->klasifikasi,
            'jadwal_retensi_arsip_aktif' => $request->jadwal_retensi_arsip_aktif,
            'jadwal_retensi_arsip_inaktif' => $request->jadwal_retensi_arsip_inaktif,
            'penyusutan_akhir' => $request->penyusutan_akhir,
            'keterangan_penyusutan' => $request->keterangan_penyusutan,
            'keamanan_arsip' => $request->keamanan_arsip,
            'lokasi_penyimpanan' => $request->lokasi_penyimpanan,
            'filling_cabinet' => $request->filling_cabinet,
            'laci' => $request->laci,
            'folder' => $request->folder,
            'kata_kunci' => $request->kata_kunci,
            'status_dokumen' => $request->status_dokumen,
            'batas_status_retensi_aktif' => $request->batas_status_retensi_aktif,
            'batas_status_retensi_inaktif' => $request->batas_status_retensi_inaktif,
            'vital' => $request->vital,
            'terjaga' => $request->terjaga,
            'memori_kolektif_bangsa' => $request->memori_kolektif_bangsa,
            'arsip_dokumen' => $fileNames, // array JSON
            'dibuat_oleh' => Auth::id(),
        ]);

        log_aktivitas('Mengunggah arsip: ' . $request->nama_dokumen);

        return redirect()->route('arsip.index')->with('success', 'Data arsip berhasil disimpan.');
    }

    public function generateKodeDokumen(Request $request)
    {
        $klasifikasi = Klasifikasi::find($request->klasifikasi);
        $kodeKlasifikasi = $klasifikasi ? $klasifikasi->kode_klasifikasi : 'XXX';

        $tanggal = $request->tanggal_arsip ?: now()->toDateString();
        $tahun = date('Y', strtotime($tanggal));

        $jumlahArsipTahunIni = Arsip::whereYear('tanggal_arsip', $tanggal)->count();
        $nomorUrut = str_pad($jumlahArsipTahunIni + 1, 3, '0', STR_PAD_LEFT);

        $kodeDokumen = $kodeKlasifikasi . '/' . $tahun . '/' . $nomorUrut;

        return response()->json(['kode_dokumen' => $kodeDokumen]);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        // dapatkan data berdasarakan "id"
        $arsip = Arsip::with('user', 'dasarHukum', 'klasifikasiData')->findOrFail($id);
        // tampilkan form detail data
        return view('arsip.show', compact('arsip'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        // dapatkan data berdasarakan "id"
        $arsip = Arsip::findOrFail($id);
        $jenis = Jenis::all();
        $dasar_hukum = DasarHukum::all();
        $klasifikasi = Klasifikasi::all();
        // tampilkan form ubah data
        return view('arsip.edit', compact('arsip', 'jenis', 'dasar_hukum', 'klasifikasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'nama_dokumen'   => 'required',
            'tanggal_arsip'  => 'required|date',
            'arsip_dokumen.*' => 'nullable|file|mimes:pdf|max:5120',
        ], [
            'nama_dokumen.required' => 'Nama dokumen tidak boleh kosong.',
            'tanggal_arsip.required' => 'Tanggal tidak boleh kosong.',
            'tanggal_arsip.date' => 'Tanggal tidak valid.',
            'arsip_dokumen.*.file' => 'Setiap file harus berupa dokumen.',
            'arsip_dokumen.*.mimes' => 'Setiap file harus berupa PDF.',
            'arsip_dokumen.*.max' => 'Ukuran maksimal file adalah 5 MB.',
        ]);

        // Ambil data arsip lama
        $arsip = Arsip::findOrFail($id);

        // Data yang diizinkan untuk diupdate
        $data = $request->only([
            'kode_dokumen',
            'nama_dokumen',
            'tanggal_arsip',
            'deskripsi_arsip',
            'dasar_hukum',
            'klasifikasi',
            'jadwal_retensi_arsip_aktif',
            'jadwal_retensi_arsip_inaktif',
            'penyusutan_akhir',
            'keterangan_penyusutan',
            'keamanan_arsip',
            'lokasi_penyimpanan',
            'filling_cabinet',
            'laci',
            'folder',
            'kata_kunci',
            'status_dokumen',
            'batas_status_retensi_aktif',
            'batas_status_retensi_inaktif',
            'vital',
            'terjaga',
            'memori_kolektif_bangsa',
            'waktu_pembuatan_arsip'
        ]);

        // Tambahkan kolom tetap (hardcoded)
        $data['verifikasi_arsip'] = 'Verifikasi';
        $data['dasar_hukum'] = $request->dasar_hukum ?? $arsip->dasar_hukum;
        $data['klasifikasi'] = $request->klasifikasi ?? $arsip->klasifikasi;

        // Update ke database
        $arsip->update($data);

        // Redirect kembali ke halaman index
        return redirect()->route('arsip.index')->with('success', 'Data arsip dokumen berhasil diubah.');
    }

    public function updateVerifikasi(Request $request, $nomor_dokumen): RedirectResponse
    {
        $request->validate([
            'verifikasi_arsip' => 'required|in:Disetujui,Direvisi',
            'catatan_revisi' => 'nullable|string|max:1000',
        ]);

        $arsip = Arsip::where('nomor_dokumen', $nomor_dokumen)->firstOrFail();
        $arsip->verifikasi_arsip = $request->verifikasi_arsip;

        if ($request->verifikasi_arsip === 'Direvisi') {
            $arsip->catatan_revisi = $request->catatan_revisi;
            $arsip->disetujui_oleh = null;
            log_aktivitas("Memberikan revisi pada arsip '{$arsip->nama_dokumen}' (No: {$arsip->nomor_dokumen}). Catatan: {$request->catatan_revisi}");
        } elseif ($request->verifikasi_arsip === 'Disetujui') {
            $arsip->catatan_revisi = null;
            $arsip->disetujui_oleh = Auth::id();
            log_aktivitas("Menyetujui arsip '{$arsip->nama_dokumen}' (Kode Arsip: {$arsip->kode_dokumen}).");
        }

        $arsip->save();

        // ✅ Tambah log status dokumen
        LogStatusDokumen::create([
            'nomor_dokumen' => $arsip->nomor_dokumen,
            'verifikasi_arsip' => $request->verifikasi_arsip,
            'catatan' => $request->catatan_revisi,
            'diproses_oleh' => Auth::id(),
        ]);

        return redirect()->route('arsip.show', $arsip->nomor_dokumen)
            ->with('success', 'Status arsip berhasil diperbarui.');
    }



    public function revisiUlang($nomor_dokumen)
    {
        $arsip = Arsip::where('nomor_dokumen', $nomor_dokumen)->firstOrFail();

        if (Auth::user()->role != 4 || $arsip->verifikasi_arsip !== 'Direvisi') {
            abort(403);
        }

        $arsip->verifikasi_arsip = 'Verifikasi';
        $arsip->catatan_revisi = null;
        $arsip->save();

        // ✅ Tambah log status dokumen
        LogStatusDokumen::create([
            'nomor_dokumen' => $arsip->nomor_dokumen,
            'verifikasi_arsip' => 'Verifikasi',
            'catatan' => null,
            'diproses_oleh' => Auth::id(),
        ]);

        log_aktivitas("Melakukan revisi ulang pada arsip '{$arsip->nama_dokumen}' (Kode Arsip: {$arsip->kode_dokumen}).");

        return redirect()->route('arsip.edit', $arsip->nomor_dokumen)
            ->with('success', 'Status arsip telah diubah menjadi verifikasi. Silakan lakukan pengeditan.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        // dapatkan data berdasarakan "id"
        $arsip = Arsip::findOrFail($id);

        // hapus file
        $files = is_string($arsip->arsip_dokumen)
            ? json_decode($arsip->arsip_dokumen, true)
            : $arsip->arsip_dokumen;

        if (is_array($files)) {
            foreach ($files as $file) {
                Storage::disk('public')->delete('arsip/' . $file);
            }
        }

        // hapus data
        $arsip->delete();

        // redirect ke halaman index dan tampilkan pesan berhasil hapus data
        return redirect()->route('arsip.index')->with('success', 'Data arsip dokumen berhasil dihapus.');
    }
    public function replaceFile(Request $request, $id, $index): RedirectResponse
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:5120',
        ]);

        $arsip = Arsip::findOrFail($id);
        $files = is_string($arsip->arsip_dokumen)
            ? json_decode($arsip->arsip_dokumen, true)
            : $arsip->arsip_dokumen;

        if (!isset($files[$index])) {
            return back()->withErrors(['File tidak ditemukan.']);
        }

        // Hapus file lama
        Storage::disk('public')->delete('dokumen/' . $files[$index]);

        // Simpan file baru
        $uploadedFile = $request->file('file');
        $newFilename = time() . '_' . $uploadedFile->getClientOriginalName();
        $uploadedFile->storeAs('public/dokumen', $newFilename);

        // Ganti di array
        $files[$index] = $newFilename;
        $arsip->arsip_dokumen = json_encode($files);
        $arsip->save();

        return redirect()->route('arsip.edit', $id)->with('success', 'File berhasil diganti.');
    }

    public function deleteFile($id, $index): RedirectResponse
    {
        $arsip = Arsip::findOrFail($id);

        $files = is_string($arsip->arsip_dokumen)
            ? json_decode($arsip->arsip_dokumen, true)
            : $arsip->arsip_dokumen;

        if (!isset($files[$index])) {
            return back()->withErrors(['File tidak ditemukan.']);
        }

        // Hapus file dari storage
        Storage::disk('public')->delete('dokumen/' . $files[$index]);

        // Hapus file dari array
        unset($files[$index]);
        $files = array_values($files); // reset index array biar tetap rapi

        // Simpan perubahan
        $arsip->arsip_dokumen = json_encode($files);
        $arsip->save();

        return back()->with('success', 'File berhasil dihapus.');
    }
}
