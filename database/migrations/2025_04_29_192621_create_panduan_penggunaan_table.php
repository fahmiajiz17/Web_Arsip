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
        Schema::create('panduan_penggunaan', function (Blueprint $table) {
            $table->bigIncrements('id_panduan');
            $table->string('nama_dokumen');
            $table->string('dokumen_panduan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panduan_penggunaan');
    }
};