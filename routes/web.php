<?php

use App\Exports\KlasifikasiTemplateExport;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KadaluarsaController;
use App\Http\Controllers\KlasifikasiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DasarHukumController;
use App\Http\Controllers\PanduanPenggunaanController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArsipExportController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\MusnahController;
use Maatwebsite\Excel\Facades\Excel;

//  Route yang dapat diakses jika user belum login
Route::middleware('guest')->group(function () {
    Route::redirect('/', 'login');

    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'authenticate'])->name('login.authenticate');
});

//  Route yang dapat diakses jika user sudah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // AKSES ARSIP
    Route::get('/arsip', [ArsipController::class, 'index'])->name('arsip.index');
    Route::get('/arsip/detail/{nomor_dokumen}', [ArsipController::class, 'show'])->name('arsip.show');
    Route::delete('/arsip/{id}', [ArsipController::class, 'destroy'])->name('arsip.destroy');

    Route::get('/arsip/export', [ArsipExportController::class, 'export'])->name('arsip.export');
    Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('log-aktivitas.index');


    // Kadaluarsa (Dibuka untuk semua role yang login)
    Route::get('/kadaluarsa', [KadaluarsaController::class, 'index'])->name('kadaluarsa.index');
    Route::get('/kadaluarsa/export', [KadaluarsaController::class, 'export'])->name('kadaluarsa.export');
    Route::get('/kadaluarsa/{nomor_dokumen}', [KadaluarsaController::class, 'show'])->name('kadaluarsa.show');

    Route::get('/musnah', [MusnahController::class, 'index'])->name('musnah.index');
    Route::get('/musnah/export', [MusnahController::class, 'export'])->name('musnah.export');
    Route::get('/musnah/{nomor_dokumen}', [MusnahController::class, 'show'])->name('musnah.show');

    Route::get('/panduan-penggunaan', [PanduanPenggunaanController::class, 'index'])->name('panduan.index');
    Route::post('/panduan/store', [PanduanPenggunaanController::class, 'store'])->name('panduan.store');
    Route::get('/panduan-penggunaa/detail/{id}', [PanduanPenggunaanController::class, 'show'])->name('panduan.show');


    //  Route yang dapat diakses jika user sudah login dan Role = Arsiparis
    Route::middleware('role:1')->group(function () {
        Route::post('/arsip', [ArsipController::class, 'store'])->name('arsip.store');
        Route::get('/arsip/ubah/{id}', [ArsipController::class, 'edit'])->name('arsip.edit');
        Route::put('/arsip/{id}', [ArsipController::class, 'update'])->name('arsip.update');
        Route::put('/arsip/{nomor_dokumen}/verifikasi', [ArsipController::class, 'updateVerifikasi'])->name('arsip.verifikasi');
        Route::post('/generate-kode-dokumen', [ArsipController::class, 'generateKodeDokumen'])->name('arsip.generateKodeDokumen');


        Route::delete('/arsip/{id}', [ArsipController::class, 'destroy'])->name('arsip.destroy');
        Route::put('/arsip/{id}/replace/{index}', [ArsipController::class, 'replaceFile'])->name('arsip.replaceFile');
        Route::delete('/arsip/{id}/file/{index}', [ArsipController::class, 'deleteFile'])->name('arsip.deleteFile');


        // musnah
        Route::post('/kadaluarsa/musnahkan', [KadaluarsaController::class, 'musnahkanManual'])->name('kadaluarsa.musnahkanManual');


        Route::get('/klasifikasi', [KlasifikasiController::class, 'index'])->name('klasifikasi.index');
        Route::get('/klasifikasi/tambah', [KlasifikasiController::class, 'create'])->name('klasifikasi.create');
        Route::post('/klasifikasi', [KlasifikasiController::class, 'store'])->name('klasifikasi.store');
        Route::get('/klasifikasi/ubah/{id}', [KlasifikasiController::class, 'edit'])->name('klasifikasi.edit');
        Route::put('/klasifikasi/{id}', [KlasifikasiController::class, 'update'])->name('klasifikasi.update');
        Route::delete('/klasifikasi/{id}', [KlasifikasiController::class, 'destroy'])->name('klasifikasi.destroy');
        Route::get('/klasifikasi/detail/{id}', [KlasifikasiController::class, 'show'])->name('klasifikasi.show');
        Route::post('/klasifikasi/import', [KlasifikasiController::class, 'import'])->name('klasifikasi.import');
        Route::get('/klasifikasi/export', [KlasifikasiController::class, 'export'])->name('klasifikasi.export');
        Route::get('/klasifikasi/{id}', [KlasifikasiController::class, 'getRetensi'])->name('klasifikasi.getRetensi');
        Route::get('/klasifikasi/{id}/get', [KlasifikasiController::class, 'get'])->name('klasifikasi.get');
        Route::get('/klasifikasi/template/download', function () {
            return Excel::download(new KlasifikasiTemplateExport, 'template_klasifikasi.xlsx');
        })->name('klasifikasi.template.download');

        Route::get('/klasifikasi/get-retensi/{id}', [KlasifikasiController::class, 'getRetensi']);

        Route::get('/dasarhukum', [DasarHukumController::class, 'index'])->name('dasarhukum.index');
        Route::get('/dasarhukum/tambah', [DasarHukumController::class, 'create'])->name('dasarhukum.create');
        Route::post('/dasarhukum', [DasarHukumController::class, 'store'])->name('dasarhukum.store');
        Route::get('/dasarhukum/ubah/{id}', [DasarHukumController::class, 'edit'])->name('dasarhukum.edit');
        Route::put('/dasarhukum/{id}', [DasarHukumController::class, 'update'])->name('dasarhukum.update');
        Route::delete('/dasarhukum/{id}', [DasarHukumController::class, 'destroy'])->name('dasarhukum.destroy');
        Route::get('/dasarhukum/detail/{id}', [DasarHukumController::class, 'show'])->name('dasarhukum.show');
        Route::put('/dasarhukum/{id}/replace-file', [DasarHukumController::class, 'replaceFile'])->name('dasarhukum.replaceFile');


        // Panduan Penggunaan

        Route::get('/panduan/tambah', [PanduanPenggunaanController::class, 'create'])->name('panduan.create');
        Route::get('/panduan-penggunaa/ubah/{id}', [PanduanPenggunaanController::class, 'edit'])->name('panduan.edit');
        Route::put('/panduan-penggunaa/{id}', [PanduanPenggunaanController::class, 'update'])->name('panduan.update');
        Route::delete('/panduan/{id}', [PanduanPenggunaanController::class, 'destroy'])->name('panduan.destroy');
        Route::get('/panduan/export', [PanduanPenggunaanController::class, 'export'])->name('panduan.export');
        Route::put('/panduan/{id}/replace/{index}', [PanduanPenggunaanController::class, 'replaceFile'])->name('panduan.replaceFile');
        Route::delete('/panduan/{id}/file/{index}', [PanduanPenggunaanController::class, 'deleteFile'])->name('panduan.deleteFile');

        // Laporan
        Route::get('/laporan/filter', [LaporanController::class, 'filter'])->name('laporan.filter');
        // Route::get('/laporan/print/{jenis}/{tgl_awal}/{tgl_akhir}', [LaporanController::class, 'print'])->name('laporan.print');

    });


    //  Route yang dapat diakses jika user sudah login dan Role = Operator
    Route::middleware('role:4')->group(function () {
        Route::get('/arsip/tambah', [ArsipController::class, 'create'])->name('arsip.create');
        Route::post('/arsip', [ArsipController::class, 'store'])->name('arsip.store');
        Route::get('/arsip/ubah/{id}', [ArsipController::class, 'edit'])->name('arsip.edit');
        Route::put('/arsip/{id}', [ArsipController::class, 'update'])->name('arsip.update');
        Route::put('/arsip/revisi-ulang/{nomor_dokumen}', [ArsipController::class, 'revisiUlang'])->name('arsip.revisi-ulang');
        Route::put('/arsip/{id}/replace/{index}', [ArsipController::class, 'replaceFile'])->name('arsip.replaceFile');
        Route::post('/generate-kode-dokumen', [ArsipController::class, 'generateKodeDokumen'])->name('arsip.generateKodeDokumen');


        Route::get('/get-klasifikasi/{id}', function ($id) {
            return \App\Models\Klasifikasi::select('retensi_aktif', 'retensi_inaktif', 'retensi_keterangan', 'klasifikasi_keamanan')
                ->where('id_klasifikasi', $id)
                ->first();
        });
    });

    //  Route yang dapat diakses jika user sudah login dan Role = Kabag
    Route::middleware('role:2')->group(function () {
        Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
        Route::get('/profil/ubah', [ProfilController::class, 'edit'])->name('profil.edit');
        Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');

        Route::get('/user', [UserController::class, 'index'])->name('user.index');
        Route::get('/user/tambah', [UserController::class, 'create'])->name('user.create');
        Route::post('/user', [UserController::class, 'store'])->name('user.store.data');
        Route::get('/user/ubah/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

        Route::get('/user/role', [RoleController::class, 'index'])->name('role.role');
        Route::get('/user/role/tambah', [RoleController::class, 'create'])->name('user.create-role');
        Route::post('/user/role', [RoleController::class, 'store'])->name('user.store');
        Route::get('/role/ubah/{id}', [RoleController::class, 'edit'])->name('role.edit-role');
        Route::put('/user/role/{id}', [RoleController::class, 'update'])->name('user.update-role');
        Route::delete('/role/{id}', [RoleController::class, 'destroy'])->name('role.destroy');
    });

    Route::get('/password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');

    Route::view('/tentang', 'tentang.index')->name('tentang');

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
