<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Arsip;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class UpdateStatusDokumenInaktif extends Command
{
    protected $signature = 'dokumen:update-inaktif';
    protected $description = 'Ubah status dokumen menjadi inaktif jika melewati batas retensi aktif';

    public function handle()
    {
        Log::info('Menjalankan pengecekan status dokumen inaktif...');

        $now = Carbon::now();

        $dokumen = Arsip::where('status_dokumen', 'Aktif')
            ->whereNotNull('batas_status_retensi_aktif')
            ->get();

        foreach ($dokumen as $d) {
            $batas = Carbon::parse($d->batas_status_retensi_aktif);
            if ($now->greaterThanOrEqualTo($batas)) {
                $d->status_dokumen = 'Inaktif';
                $d->save();
                Log::info("Dokumen ID {$d->id} diubah menjadi INAKTIF");
            }
        }

        $this->info('Pengecekan dokumen selesai.');
    }
}
