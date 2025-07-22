<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('users')->insert([
            [
                'nama_user' => 'Indra Styawantoro',
                'username' => 'administrator',
                'password' => Hash::make('123'),
                'role' => 'Administrator',
                'created_at'=> now(),
                'updated_at'=> now()
            ], 
            [
                'nama_user' => 'Anindira Nisaka Iswari',
                'username' => 'pengelola',
                'password' => Hash::make('123'),
                'role' => 'Pengelola Arsip',
                'created_at'=> now(),
                'updated_at'=> now()
            ], 
            [
                'nama_user' => 'Danang Kesuma',
                'username' => 'pengguna',
                'password' => Hash::make('123'),
                'role' => 'Pengguna',
                'created_at'=> now(),
                'updated_at'=> now()
            ]
        ]);

        DB::table('profil')->insert([
            'nama' => 'Dinas Kependudukan dan Pencatatan Sipil Nusantara',
            'alamat' => 'Kota Bandar Lampung, Lampung',
            'telepon' => '081377783334',
            'email' => 'disdukcapil@gmail.com',
            'website' => 'www.disdukcapil.go.id',
            'logo' => 'logo.png',
            'created_at'=> now(),
            'updated_at'=> now()
        ]);
    }
}
