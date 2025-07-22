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
            $table->enum('verifikasi_arsip', ['verifikasi', 'disetujui', 'direvisi'])->default('menunggu')->change();
            $table->text('catatan_revisi')->nullable()->after('verifikasi_arsip');
            $table->string('status_dokumen')->after('catatan_revisi');
            $table->foreignId('dibuat_oleh')->after('status_dokumen')->constrained('users');
            $table->foreignId('disetujui_oleh')->nullable()->after('dibuat_oleh')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arsip', function (Blueprint $table) {
            $table->string('verifikasi_arsip')->change();
            $table->dropColumn('catatan_revisi');
            $table->dropColumn('status_dokumen');
            $table->dropForeign(['dibuat_oleh']);
            $table->dropColumn('dibuat_oleh');
            $table->dropForeign(['disetujui_oleh']);
            $table->dropColumn('disetujui_oleh');
        });
    }
};
