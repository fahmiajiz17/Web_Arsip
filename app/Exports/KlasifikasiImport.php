<?php

namespace App\Imports;

use App\Models\Klasifikasi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;


class KlasifikasiImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    // Disable default heading formatter supaya header Excel tetap sama apa adanya
    public static function headingRowFormatter(): string
    {
        return 'none';
    }

    public function model(array $row)
    {
        return new Klasifikasi([
            'kode_klasifikasi'      => $row['Kode Klasifikasi'],
            'jenis_dokumen'         => $row['Jenis Dokumen'],
            'klasifikasi_keamanan'  => $row['Klasifikasi Keamanan'],
            'hak_akses'             => $row['Hak Akses'],
            'akses_publik'          => $row['Akses Publik'],
            'retensi_aktif'         => $row['Retensi Aktif'],
            'retensi_inaktif'       => $row['Retensi Inaktif'],
            'retensi_keterangan'    => $row['Retensi Keterangan'],
            'unit_pengolah'         => $row['Unit Pengolah'],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.Kode Klasifikasi'     => 'required|string|max:255',
            '*.Jenis Dokumen'        => 'required|string|max:255',
            '*.Klasifikasi Keamanan' => 'required|string|max:255',
            '*.Hak Akses'            => 'required|string|max:255',
            '*.Akses Publik'         => 'required|string|max:255',
            '*.Retensi Aktif'        => 'required|integer',
            '*.Retensi Inaktif'      => 'required|integer',
            '*.Retensi Keterangan'   => 'nullable|string|max:255',
            '*.Unit Pengolah'        => 'required|string|max:255',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.Kode Klasifikasi.required' => 'Kolom Kode Klasifikasi harus diisi.',
            '*.Jenis Dokumen.required' => 'Kolom Jenis Dokumen harus diisi.',
            '*.Klasifikasi Keamanan.required' => 'Kolom Klasifikasi Keamanan harus diisi.',
            '*.Hak Akses.required' => 'Kolom Hak Akses harus diisi.',
            '*.Akses Publik.required' => 'Kolom Akses Publik harus diisi.',
            '*.Retensi Aktif.required' => 'Kolom Retensi Aktif harus diisi dan berupa angka.',
            '*.Retensi Inaktif.required' => 'Kolom Retensi Inaktif harus diisi dan berupa angka.',
            '*.Unit Pengolah.required' => 'Kolom Unit Pengolah harus diisi.',
        ];
    }
}
