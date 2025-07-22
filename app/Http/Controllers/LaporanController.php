<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Jenis;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanController extends Controller
{
    /**
     * filter
     */
    public function filter(Request $request): View
    {
        // menampilkan data berdasarkan filter
        if ($request->has(['jenis', 'tgl_awal', 'tgl_akhir'])) {
            // validasi form
            $request->validate([
                'jenis'     => 'required',
                'tgl_awal'  => 'required|date',
                'tgl_akhir' => 'required|date|after_or_equal:tgl_awal'
            ], [
                'jenis.required'           => 'Jenis dokumen tidak boleh kosong.',
                'tgl_awal.required'        => 'Tanggal awal tidak boleh kosong.',
                'tgl_awal.date'            => 'Tanggal awal harus berupa tanggal yang valid.',
                'tgl_akhir.required'       => 'Tanggal akhir tidak boleh kosong.',
                'tgl_akhir.date'           => 'Tanggal akhir harus berupa tanggal yang valid.',
                'tgl_akhir.after_or_equal' => 'Tanggal akhir harus berupa tanggal setelah atau sama dengan tanggal awal.'
            ]);

            // data filter
            $jenisId  = $request->jenis;
            $tglAwal  = $request->tgl_awal;
            $tglAkhir = $request->tgl_akhir;

            if ($jenisId == 'Semua') {
                // menampilkan data berdasarkan filter tanggal pembuatan
                $arsip = Arsip::select('id', 'nama_dokumen', 'nomor_dokumen', 'tanggal_pembuatan', 'jenis_id')->with('jenis:id,nama')
                    ->whereBetween('tanggal_pembuatan', [$tglAwal, $tglAkhir])
                    ->orderBy('tanggal_pembuatan', 'asc')
                    ->get();
            } else {
                // menampilkan data berdasarkan filter jenis dan tanggal pembuatan
                $arsip = Arsip::select('id', 'nama_dokumen', 'nomor_dokumen', 'tanggal_pembuatan', 'jenis_id')->with('jenis:id,nama')
                    ->where('jenis_id', $jenisId)
                    ->whereBetween('tanggal_pembuatan', [$tglAwal, $tglAkhir])
                    ->orderBy('tanggal_pembuatan', 'asc')
                    ->get();
            }

            // ambil data jenis untuk form select
            $jenis = Jenis::get(['id', 'nama']);

            // ambil data nama jenis untuk judul laporan
            $fieldJenis = Jenis::select('nama')
                ->where('id', $jenisId)
                ->first();

            // tampilkan data ke view
            return view('laporan.filter', compact('arsip', 'jenis', 'fieldJenis'));
        } 
        // menampilkan form filter data
        else {
            // ambil data jenis untuk form select
            $jenis = Jenis::get(['id', 'nama']);
    
            // tampilkan data ke view
            return view('laporan.filter', compact('jenis'));
        }
    }

    /**
     * print (PDF)
     */
    public function print(Request $request)
    {
        // data filter
        $jenisId  = $request->jenis;
        $tglAwal  = $request->tgl_awal;
        $tglAkhir = $request->tgl_akhir;

        if ($jenisId == 'Semua') {
            // menampilkan data berdasarkan filter tanggal pembuatan
            $arsip = Arsip::select('id', 'nama_dokumen', 'nomor_dokumen', 'tanggal_pembuatan', 'jenis_id')->with('jenis:id,nama')
                ->whereBetween('tanggal_pembuatan', [$tglAwal, $tglAkhir])
                ->orderBy('tanggal_pembuatan', 'asc')
                ->get();
        } else {
            // menampilkan data berdasarkan filter jenis dan tanggal pembuatan
            $arsip = Arsip::select('id', 'nama_dokumen', 'nomor_dokumen', 'tanggal_pembuatan', 'jenis_id')->with('jenis:id,nama')
                ->where('jenis_id', $jenisId)
                ->whereBetween('tanggal_pembuatan', [$tglAwal, $tglAkhir])
                ->orderBy('tanggal_pembuatan', 'asc')
                ->get();
        }

        // ambil data nama jenis untuk judul laporan
        $fieldJenis = Jenis::select('nama')
            ->where('id', $jenisId)
            ->first();

        // load view PDF
        $pdf = Pdf::loadview('laporan.print', compact('arsip', 'fieldJenis'))->setPaper('a4', 'landscape');
        // tampilkan ke browser
        return $pdf->stream('Laporan-Data-Arsip-Dokumen.pdf');
    }
}