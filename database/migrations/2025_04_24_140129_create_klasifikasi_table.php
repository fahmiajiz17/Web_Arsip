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
        Schema::create('klasifikasi', function (Blueprint $table) {
            $table->bigIncrements('id_klasifikasi');
            $table->string('kode_klasifikasi');
            $table->string('jenis_dokumen');
            $table->string('klasifikasi_keamanan');
            $table->string('hak_akses');
            $table->string('akses_publik');
            $table->integer('retensi_aktif');
            $table->integer('retensi_inaktif');
            $table->string('retensi_keterangan');
            $table->string('unit_pengolah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klasifikasi');
    }
};