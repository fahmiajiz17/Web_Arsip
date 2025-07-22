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
        Schema::create('log_status_dokumen', function (Blueprint $table) {
            $table->bigIncrements('id_log_status_dokumen');
            $table->unsignedBigInteger('nomor_dokumen'); // sama tipe-nya dengan arsip.nomor_dokumen
            $table->enum('verifikasi_arsip', ['Verifikasi', 'Disetujui', 'Direvisi']);
            $table->text('catatan')->nullable();
            $table->foreignId('diproses_oleh')->constrained('users');
            $table->timestamps();
            $table->foreign('nomor_dokumen')->references('nomor_dokumen')->on('arsip')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_status_dokumen');
    }
};
