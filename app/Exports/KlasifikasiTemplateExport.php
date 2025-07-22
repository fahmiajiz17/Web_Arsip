<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KlasifikasiTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        // Kosong, karena ini hanya template header
        return [];
    }

    public function headings(): array
    {
        return [
            'Kode Klasifikasi',
            'Jenis Dokumen',
            'Klasifikasi Keamanan',
            'Hak Akses',
            'Akses Publik',
            'Retensi Aktif',
            'Retensi Inaktif',
            'Retensi Keterangan',
            'Unit Pengolah',
        ];
    }
}
