<?php

namespace App\Http\Controllers;

use App\Models\Klasifikasi;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Imports\KlasifikasiImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KlasifikasiExport;

class KlasifikasiController extends Controller
{
    public function index(Request $request): View
    {
        $perPage = $request->input('perPage', 5);

        if ($request->search) {
            $search = $request->search;
            $klasifikasi = Klasifikasi::select('id_klasifikasi', 'kode_klasifikasi', 'jenis_dokumen', 'retensi_aktif', 'retensi_inaktif')
                ->where(function ($query) use ($search) {
                    $query->where('kode_klasifikasi', 'LIKE', "%$search%")
                        ->orWhere('jenis_dokumen', 'LIKE', "%$search%")
                        ->orWhere('retensi_aktif', 'LIKE', "%$search%")
                        ->orWhere('retensi_inaktif', 'LIKE', "%$search%");
                })
                ->paginate($perPage)
                ->withQueryString();
        } else {
            $klasifikasi = Klasifikasi::select('id_klasifikasi', 'kode_klasifikasi', 'jenis_dokumen', 'retensi_aktif', 'retensi_inaktif')
                ->orderBy('id_klasifikasi', 'asc') // ganti ke 'id_klasifikasi' jika memang nama kolomnya seperti itu
                ->paginate($perPage);
        }

        return view('arsip.klasifikasi.index', compact('klasifikasi'))
            ->with('i', ($request->input('page', 1) - 1) * $perPage);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // tampilkan form tambah data
        return view('arsip.klasifikasi.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        // dapatkan data berdasarakan "id"
        $klasifikasi = Klasifikasi::findOrFail($id);

        // tampilkan form detail data
        return view('arsip.klasifikasi.show', compact('klasifikasi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // validasi form
        $request->validate([
            'kode_klasifikasi' => 'required|unique:klasifikasi',
            'jenis_dokumen' => 'required',
            'klasifikasi_keamanan' => 'required',
            'hak_akses' => 'required',
            'akses_publik' => 'required',
            'retensi_aktif' => 'required',
            'retensi_inaktif' => 'required',
            'retensi_keterangan' => 'required',
            'unit_pengolah' => 'required'
        ], [
            'kode_klasifikasi.required' => 'Kode klasifikasi tidak boleh kosong.',
            'kode_klasifikasi.unique'   => 'Kode klasifikasi sudah ada.',
            'jenis_dokumen.required' => 'Jenis dokumen tidak boleh kosong.',
            'klasifikasi_keamanan.required' => 'Klasifikasi keamanan tidak boleh kosong',
            'hak_akses.required' => 'Hak akses tidak boleh kosong',
            'akses_publik.required' => 'Akses publik tidak boleh kosong',
            'retensi_aktif.required' => 'Retensi aktif tidak boleh kosong',
            'retensi_inaktif.required' => 'Retensi inaktif tidak boleh kosong',
            'retensi_keterangan.required' => 'Retensi keterangan tidak boleh kosong',
            'unit_pengolah.required' => 'Unit pengolahan tidak boleh kosong',
        ]);

        // simpan data
        Klasifikasi::create([
            'kode_klasifikasi' => $request->kode_klasifikasi,
            'jenis_dokumen' => $request->jenis_dokumen,
            'klasifikasi_keamanan' => $request->klasifikasi_keamanan,
            'hak_akses' => $request->hak_akses,
            'akses_publik' => $request->akses_publik,
            'retensi_aktif' => $request->retensi_aktif,
            'retensi_inaktif' => $request->retensi_inaktif,
            'retensi_keterangan' => $request->retensi_keterangan,
            'unit_pengolah' => $request->unit_pengolah
        ]);

        // redirect ke halaman index dan tampilkan pesan berhasil simpan data
        return redirect()->route('klasifikasi.index')->with('success', 'Data klasifikasi berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        // dapatkan data berdasarakan "id"
        $klasifikasi = Klasifikasi::findOrFail($id);

        // tampilkan form ubah data
        return view('arsip.klasifikasi.edit', compact('klasifikasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // validasi form
        $request->validate([
            'kode_klasifikasi' => 'required|unique:klasifikasi,kode_klasifikasi,' . $id . ',id_klasifikasi',
            'jenis_dokumen' => 'required',
            'klasifikasi_keamanan' => 'required',
            'hak_akses' => 'required',
            'akses_publik' => 'required',
            'retensi_aktif' => 'required|numeric',
            'retensi_inaktif' => 'required|numeric',
            'retensi_keterangan' => 'required',
            'unit_pengolah' => 'required'
        ], [
            'kode_klasifikasi.required' => 'Kode klasifikasi tidak boleh kosong.',
            'kode_klasifikasi.unique' => 'Kode klasifikasi sudah ada.',
            'jenis_dokumen.required' => 'Jenis dokumen tidak boleh kosong.',
            'klasifikasi_keamanan.required' => 'Klasifikasi keamanan tidak boleh kosong.',
            'hak_akses.required' => 'Hak akses tidak boleh kosong.',
            'akses_publik.required' => 'Akses publik tidak boleh kosong.',
            'retensi_aktif.required' => 'Retensi aktif tidak boleh kosong.',
            'retensi_aktif.numeric' => 'Retensi aktif harus berupa angka.',
            'retensi_inaktif.required' => 'Retensi inaktif tidak boleh kosong.',
            'retensi_inaktif.numeric' => 'Retensi inaktif harus berupa angka.',
            'retensi_keterangan.required' => 'Retensi keterangan tidak boleh kosong.',
            'unit_pengolah.required' => 'Unit pengolah tidak boleh kosong.'
        ]);

        // dapatkan data berdasarkan "id"
        $klasifikasi = Klasifikasi::findOrFail($id);

        // ubah data
        $klasifikasi->update([
            'kode_klasifikasi' => $request->kode_klasifikasi,
            'jenis_dokumen' => $request->jenis_dokumen,
            'klasifikasi_keamanan' => $request->klasifikasi_keamanan,
            'hak_akses' => $request->hak_akses,
            'akses_publik' => $request->akses_publik,
            'retensi_aktif' => $request->retensi_aktif,
            'retensi_inaktif' => $request->retensi_inaktif,
            'retensi_keterangan' => $request->retensi_keterangan,
            'unit_pengolah' => $request->unit_pengolah
        ]);

        // redirect ke halaman index dan tampilkan pesan berhasil ubah data
        return redirect()->route('klasifikasi.index')->with('success', 'Data klasifikasi berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        // dapatkan data berdasarakan "id"
        $jenis = Klasifikasi::findOrFail($id);

        // hapus data
        $jenis->delete();

        // redirect ke halaman index dan tampilkan pesan berhasil hapus data
        return redirect()->route('klasifikasi.index')->with('success', 'Data klasifikasi berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $import = new KlasifikasiImport;

        Excel::import($import, $request->file('file'));

        // Cek apakah ada error validasi pada import
        if ($import->failures()->isNotEmpty()) {
            // Buat array pesan error dari failures
            $errorMessages = [];

            foreach ($import->failures() as $failure) {
                $row = $failure->row();          // nomor baris
                $attribute = $failure->attribute(); // nama kolom
                foreach ($failure->errors() as $error) {
                    $errorMessages[] = "Baris $row, kolom $attribute: $error";
                }
            }

            return redirect()->route('klasifikasi.index')->with([
                'error' => 'Beberapa Data Gagal diimpor. Periksa data dan coba lagi.',
                'failures' => $errorMessages,
            ]);
        }

        return redirect()->route('klasifikasi.index')->with('success', 'Data berhasil diimpor.');
    }


    public function export()
    {
        return Excel::download(new KlasifikasiExport, 'Arsip_Klasifikasi_LLDIKTI4.xlsx');
    }

    public function getRetensi($id)
    {
        $klasifikasi = Klasifikasi::select('retensi_aktif', 'retensi_inaktif')->findOrFail($id);
        return response()->json($klasifikasi);
    }
}
