<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Arsip;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MusnahExport;
use Illuminate\Contracts\View\View;

class MusnahController extends Controller
{
    public function index(Request $request)
    {
        $query = Arsip::whereNotNull('surat_berita_path')
            ->where('status_dokumen', 'Musnah');

        // Batasi akses berdasarkan role
        if (!in_array($request->user()->role, [1, 2, 3])) {
            $query->where('dibuat_oleh', Auth::id());
        }

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_dokumen', 'like', '%' . $request->search . '%')
                    ->orWhere('tanggal_arsip', 'like', '%' . $request->search . '%')
                    ->orWhere('kode_dokumen', 'like', '%' . $request->search . '%');
            });
        }

        // Filter rentang tanggal berdasarkan tanggal arsip
        if ($request->filled('range')) {
            $range = explode(' to ', $request->range);
            if (count($range) === 2) {
                try {
                    $start = Carbon::createFromFormat('d-m-Y', trim($range[0]))->startOfDay();
                    $end = Carbon::createFromFormat('d-m-Y', trim($range[1]))->endOfDay();

                    $query->whereBetween('tanggal_arsip', [$start, $end]);
                } catch (\Exception $e) {
                    // Abaikan jika parsing gagal
                }
            }
        }


        $sortOrder = $request->get('sort', 'desc');
        $query->orderBy('tanggal_arsip', $sortOrder);

        $musnah = $query->paginate(10)->withQueryString();

        return view('musnah.index', compact('musnah'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function show(string $nomor_dokumen): View
    {
        $arsip = Arsip::where('nomor_dokumen', $nomor_dokumen)
            ->where('status_dokumen', 'Musnah')
            ->firstOrFail();

        return view('musnah.show', compact('arsip'));
    }

    public function export(Request $request)
    {
        return Excel::download(new MusnahExport($request), 'Arsip_Musnah_LLDIKTI4.xlsx');
    }
}
