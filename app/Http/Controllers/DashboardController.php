<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Klasifikasi;
use App\Models\PanduanPenggunaan;
use App\Models\User;
use App\Models\Profil;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $user = Auth::user();

        if ($user->role == 1) {
            // Untuk role 1, hanya ambil arsip yang butuh verifikasi
            $totalArsip = Arsip::where('verifikasi_arsip', 'Verifikasi')->count();
            $arsipTerbaru = Arsip::where('verifikasi_arsip', 'Verifikasi')->latest()->take(5)->get();

            $arsipPerKlasifikasi = Arsip::with('klasifikasiData')
                ->select('klasifikasi', DB::raw('COUNT(*) as jumlah'))
                ->groupBy('klasifikasi')
                ->get()
                ->map(function ($item) {
                    return (object)[
                        'kode_klasifikasi' => $item->klasifikasiData->kode_klasifikasi ?? '-',
                        'jenis_dokumen' => $item->klasifikasiData->jenis_dokumen ?? '-',
                        'jumlah' => $item->jumlah
                    ];
                });

            // Grafik arsip per tahun tetap semua arsip (atau bisa disesuaikan jika mau khusus arsip butuh verifikasi)
            $arsipPerTahun = Arsip::selectRaw('YEAR(tanggal_arsip) as tahun, COUNT(*) as jumlah')
                ->whereNotNull('tanggal_arsip')
                ->groupBy(DB::raw('YEAR(tanggal_arsip)'))
                ->orderBy('tahun')
                ->get();
        } elseif (in_array($user->role, [2, 3])) {
            // Untuk role 2 dan 3 tetap ambil semua arsip terbaru
            $totalArsip = Arsip::count();
            $arsipTerbaru = Arsip::latest()->take(5)->get();

            $arsipPerKlasifikasi = Arsip::with('klasifikasiData')
                ->select('klasifikasi', DB::raw('COUNT(*) as jumlah'))
                ->groupBy('klasifikasi')
                ->get()
                ->map(function ($item) {
                    return (object)[
                        'kode_klasifikasi' => $item->klasifikasiData->kode_klasifikasi ?? '-',
                        'jenis_dokumen' => $item->klasifikasiData->jenis_dokumen ?? '-',
                        'jumlah' => $item->jumlah
                    ];
                });

            $arsipPerTahun = Arsip::selectRaw('YEAR(tanggal_arsip) as tahun, COUNT(*) as jumlah')
                ->whereNotNull('tanggal_arsip')
                ->groupBy(DB::raw('YEAR(tanggal_arsip)'))
                ->orderBy('tahun')
                ->get();
        } elseif ($user->role == 4) {
            $totalArsip = Arsip::where('dibuat_oleh', $user->id)->count();
            $arsipTerbaru = Arsip::where('dibuat_oleh', $user->id)->latest()->take(5)->get();

            $arsipPerKlasifikasi = Arsip::with('klasifikasiData')
                ->select('klasifikasi', DB::raw('COUNT(*) as jumlah'))
                ->where('dibuat_oleh', $user->id)
                ->groupBy('klasifikasi')
                ->get()
                ->map(function ($item) {
                    return (object)[
                        'kode_klasifikasi' => $item->klasifikasiData->kode_klasifikasi ?? '-',
                        'jenis_dokumen' => $item->klasifikasiData->jenis_dokumen ?? '-',
                        'jumlah' => $item->jumlah
                    ];
                });

            $arsipPerTahun = Arsip::selectRaw('YEAR(tanggal_arsip) as tahun, COUNT(*) as jumlah')
                ->where('dibuat_oleh', $user->id)
                ->whereNotNull('tanggal_arsip')
                ->groupBy(DB::raw('YEAR(tanggal_arsip)'))
                ->orderBy('tahun')
                ->get();
        } else {
            $totalArsip = Arsip::where('dibuat_oleh', $user->id)->count();
            $arsipTerbaru = Arsip::where('dibuat_oleh', $user->id)->latest()->take(5)->get();
            $arsipPerKlasifikasi = collect();
            $arsipPerTahun = collect();
        }

        // Data lain tetap sama...
        $totalUser = User::count();
        $totalDokumenPanduan = PanduanPenggunaan::count();
        $totalSeluruhArsip = Arsip::count();

        $totalArsipAktif = Arsip::countByStatusForUser('Aktif', $user);
        $totalArsipKadaluarsa = Arsip::countByStatusForUser('Inaktif', $user);
        $totalArsipMusnah = Arsip::countByStatusForUser('Musnah', $user);

        $profil = Profil::first();

        return view('dashboard.index', compact(
            'totalSeluruhArsip',
            'totalArsip',
            'totalUser',
            'totalDokumenPanduan',
            'arsipTerbaru',
            'totalArsipKadaluarsa',
            'totalArsipMusnah',
            'totalArsipAktif',
            'arsipPerTahun',
            'profil',
            'arsipPerKlasifikasi'
        ));
    }
}
