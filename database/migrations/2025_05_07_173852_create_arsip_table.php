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
            $table->bigIncrements('nomor_dokumen');
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
            $table->enum('verifikasi_arsip', ['Verifikasi', 'Direvisi', 'Disetujui'])->default('Verifikasi');
            $table->text('catatan_revisi')->nullable();
            $table->string('status_dokumen');
            $table->foreignId('dibuat_oleh')->constrained('users');
            $table->foreignId('disetujui_oleh')->nullable()->constrained('users');
            $table->date('batas_status_retensi_aktif');
            $table->date('batas_status_retensi_inaktif');
            $table->string('vital');
            $table->string('terjaga');
            $table->string('memori_kolektif_bangsa');
            $table->string('arsip_dokumen');
            $table->timestamps();
            $table->string('surat_berita_path')->nullable();
            $table->date('tanggal_musnahkan')->nullable()->comment('Tanggal arsip dimusnahkan');
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