<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('arsip', function (Blueprint $table) {
            $table->date('tanggal_musnahkan')->nullable()->after('surat_berita_path')->comment('Tanggal arsip dimusnahkan');
        });
    }

    public function down()
    {
        Schema::table('arsip', function (Blueprint $table) {
            $table->dropColumn('tanggal_musnahkan');
        });
    }
};
