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
        Schema::create('profil', function (Blueprint $table) {
            $table->unsignedInteger('id_profil');
            $table->string('nama_aplikasi');
            $table->string('kepanjangan_aplikasi');
            $table->string('nama_copyright');
            $table->string('logo_kerjasama');
            $table->string('logo_instansi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil');
    }
};