<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('arsip', function (Blueprint $table) {
            $table->string('lokasi_penyimpanan')->nullable();
            $table->string('filling_cabinet')->nullable();
            $table->string('laci')->nullable();
            $table->string('folder')->nullable();
            $table->string('deskripsi')->nullable();
            $table->string('indeks')->nullable();
            $table->date('tanggal_arsip')->nullable();
            $table->string('dasar_hukum')->nullable();
            $table->string('klasifikasi_arsip')->nullable();
            $table->date('jadwal_retensi_arsip_aktif')->nullable();
            $table->date('jadwal_retensi_arsip_inaktif')->nullable();
            $table->string('penyusutan_akhir')->nullable();
            $table->string('keterangan_penyusutan')->nullable();
            $table->string('keamanan_arsip')->nullable();
            $table->string('verifikasi_arsip')->nullable();
            $table->date('batas_status_retensi_aktif')->nullable();
            $table->date('batas_status_retensi_inaktif')->nullable();
            $table->string('vital')->nullable();
            $table->string('terjaga')->nullable();
            $table->string('memori_kolektif_bangsa')->nullable();
            $table->date('waktu_pembuatan_informasi')->nullable();
            $table->string('pembuat_daftar_berkas')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arsip', function (Blueprint $table) {
            $table->dropForeign(['lokasi_penyimpanan','filling_cabinet','laci','folder','deskripsi','indeks','tanggal_arsip','dasar_hukum','klasifikasi_arsip',
            'jadwal_retensi_arsip_aktif','jadwal_retensi_arsip_inaktif','penyusutan_akhir',
            'keterangan_penyusutan','keamanan_arsip','verifikasi_arsip','batas_status_retensi_aktif',
            'batas_status_retensi_inaktif','vital','terjaga','memori_kolektif_bangsa','waktu_pembuatan_informasi','pembuat_daftar_berkas']);
        });
    }
};
