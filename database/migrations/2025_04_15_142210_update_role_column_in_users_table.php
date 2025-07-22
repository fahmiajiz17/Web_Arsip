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
        Schema::table('users', function (Blueprint $table) {
            // Mengubah kolom role menjadi unsignedBigInteger
            $table->unsignedBigInteger('role')->change();
            // Menambahkan foreign key constraint
            $table->foreign('role')->references('id')->on('role')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus foreign key dan mengubah tipe kolom ke integer biasa
            $table->dropForeign(['role']);
            $table->integer('role')->change();
        });
    }
};