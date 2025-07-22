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
        Schema::create('arsip', function (Blueprint $table) {
            $table->unsignedBigInteger('nomor_dokumen')->unique();
            $table->string('kode_dokumen')->unique();
            $table->string('nama_dokumen');
            $table->date('tanggal_arsip');
            $table->string('deskripsi_arsip');
            $table->unsignedBigInteger('dasar_hukum');
            $table->foreign('dasar_hukum')->references('id_dasar_hukum')->on('dasar_hukum');
            $table->unsignedBigInteger('klasifikasi');
            $table->foreign('klasifikasi')->references('id_klasifikasi')->on('klasifikasi');
            $table->integer('jadwal_retensi_arsip_aktif');
            $table->integer('jadwal_retensi_arsip_inaktif');
            $table->string('penyusutan_akhir');
            $table->string('keterangan_penyusutan');
            $table->string('keamanan_arsip');
            $table->string('lokasi_penyimpanan');
            $table->string('filling_cabinet');
            $table->string('laci');
            $table->string('folder');
            $table->string('kata_kunci');
            $table->string('verifikasi_arsip');
            $table->string('batas_retensi_aktif');
            $table->string('batas_retensi_inaktif');
            $table->string('vital');
            $table->string('terjaga');
            $table->string('memori_kolektif_bangsa');
            $table->string('waktu_pembuatan_arsip');
            $table->string('pembuat_arsip');
            $table->string('arsip_dokumen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip');
    }
};
