<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KadaluarsaExport;

class KadaluarsaController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->input('perPage', 10);
        $sort = $request->input('sort', 'asc');

        $query = Arsip::with(['dasarHukumData', 'klasifikasiDataExport', 'user', 'disetujuiOlehUser'])
            ->where('status_dokumen', 'Inaktif')
            ->where('verifikasi_arsip', 'Disetujui');

        // 🔐 Role 1-3 bisa akses semua, lainnya hanya data miliknya
        if (!in_array($request->user()->role, [1, 2, 3])) {
            $query->where('dibuat_oleh', $request->user()->id);
        }

        // 🔍 Pencarian (jika ada)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_dokumen', 'like', "%$search%")
                    ->orWhere('kode_dokumen', 'like', "%$search%")
                    ->orWhere('tanggal_arsip', 'like', '%' . $search . '%');
            });
        }

        // 📅 Filter rentang tanggal (jika ada)
        if ($request->filled('range')) {
            $range = explode(' to ', $request->range);

            try {
                if (count($range) === 2) {
                    $start = Carbon::createFromFormat('d-m-Y', trim($range[0]))->startOfDay();
                    $end = Carbon::createFromFormat('d-m-Y', trim($range[1]))->endOfDay();
                    $query->whereBetween('tanggal_arsip', [$start, $end]);
                } elseif (count($range) === 1 && !empty($range[0])) {
                    $single = Carbon::createFromFormat('d-m-Y', trim($range[0]))->startOfDay();
                    $query->whereDate('tanggal_arsip', $single);
                }
            } catch (\Exception $e) {
                // Abaikan jika format tanggal salah
            }
        }

        // ⬇️ Urut berdasarkan tanggal retensi
        $query->orderBy('batas_status_retensi_inaktif', $sort);

        // 📄 Paginate dengan query string dibawa
        $kadaluarsa = $query->paginate($perPage)->withQueryString();

        return view('kadaluarsa.index', compact('kadaluarsa', 'sort', 'perPage'))
            ->with('i', ($request->input('page', 1) - 1) * $perPage);
    }



    public function show(string $nomor_dokumen)
    {
        $arsip = Arsip::where('nomor_dokumen', $nomor_dokumen)
            ->where('status_dokumen', 'Inaktif')
            ->firstOrFail();

        return view('kadaluarsa.show', compact('arsip'));
    }

    public function musnahkanManual(Request $request)
    {
        $request->validate([
            'dokumen_ids' => 'required|array',
            'surat_berita' => 'required|file|mimes:pdf|max:2048',
            'tanggal_musnahkan' => 'required|date|before_or_equal:today',
        ]);

        // Upload file
        $file = $request->file('surat_berita');
        $filename = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('surat_berita', $filename, 'public');

        // Update data arsip berdasarkan kode_dokumen
        Arsip::whereIn('kode_dokumen', $request->dokumen_ids)->update([
            'status_dokumen' => 'Musnah',
            'surat_berita_path' => $filePath,
            'tanggal_musnahkan' => $request->tanggal_musnahkan, // <-- simpan tanggal
        ]);

        return redirect()->back()->with('success', 'Surat berita berhasil diupload dan arsip dimusnahkan.');
    }


    public function export(Request $request)
    {
        return Excel::download(new KadaluarsaExport($request), 'Arsip_Inaktif_LLDIKTI4.xlsx');
    }
}
