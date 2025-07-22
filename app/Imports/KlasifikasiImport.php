<?php

namespace App\Imports;

use App\Models\Klasifikasi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Validation\Rule;

class KlasifikasiImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        // Jika kode sudah ada di DB, skip baris ini
        if (Klasifikasi::where('kode_klasifikasi', $row['kode_klasifikasi'])->exists()) {
            return null;
        }

        return new Klasifikasi([
            'kode_klasifikasi' => $row['kode_klasifikasi'],
            'jenis_dokumen' => $row['jenis_dokumen'],
            'klasifikasi_keamanan' => $row['klasifikasi_keamanan'],
            'hak_akses' => $row['hak_akses'],
            'akses_publik' => $row['akses_publik'],
            'retensi_aktif' => $row['retensi_aktif'],
            'retensi_inaktif' => $row['retensi_inaktif'],
            'retensi_keterangan' => $row['retensi_keterangan'],
            'unit_pengolah' => $row['unit_pengolah'],
        ]);
    }

    public function rules(): array
    {
        return [
            'kode_klasifikasi' => [
                'required',
                // Validasi agar tidak duplikat di database
                Rule::unique('klasifikasi', 'kode_klasifikasi'),
            ],
            'jenis_dokumen' => 'required',
            'klasifikasi_keamanan' => 'required',
            'hak_akses' => 'required',
            'akses_publik' => 'required',
            'retensi_aktif' => 'required|numeric',
            'retensi_inaktif' => 'required|numeric',
            'retensi_keterangan' => 'required',
            'unit_pengolah' => 'required',
        ];
    }
}
