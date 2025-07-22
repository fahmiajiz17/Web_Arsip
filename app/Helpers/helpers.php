<?php

use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

if (! function_exists('log_aktivitas')) {
    function log_aktivitas(string $aktivitas): void
    {
        $user = Auth::user(); // akan selalu ada karena kita tidak izinkan anonymous

        // Tambahkan pengecekan tambahan jika perlu
        if (!$user) {
            return; // Tidak mencatat log jika tidak login
        }

        LogAktivitas::create([
            'user_id' => $user->id,
            'aktivitas' => $aktivitas,
        ]);
    }
}
