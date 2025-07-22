<?php

namespace App\Exports;

use App\Models\Klasifikasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class KlasifikasiExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $no = 1;

    /**
     * Ambil semua data klasifikasi.
     */
    public function collection()
    {
        return Klasifikasi::all();
    }

    /**
     * Mapping setiap baris data untuk diekspor.
     */
    public function map($row): array
    {
        return [
            $this->no++, // Nomor urut
            $row->kode_klasifikasi,
            $row->jenis_dokumen,
            $row->klasifikasi_keamanan,
            $row->hak_akses,
            $row->akses_publik,
            $row->retensi_aktif . ' Tahun',
            $row->retensi_inaktif . ' Tahun',
            $row->retensi_keterangan,
            $row->unit_pengolah,
        ];
    }

    /**
     * Judul kolom untuk file Excel.
     */
    public function headings(): array
    {
        return [
            'No',
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

    /**
     * Event untuk styling Excel: judul + styling header + autosize.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // Sisipkan 2 baris di atas header agar header pindah ke baris 3
                $sheet->insertNewRowBefore(1, 2);

                // Judul utama di baris 1
                $sheet->setCellValue('A1', 'ARSIP KLASIFIKASI LLDIKTI WILAYAH IV');
                $sheet->mergeCells('A1:J1'); // Sesuaikan dengan jumlah kolom
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $sheet->getDelegate()->getRowDimension(1)->setRowHeight(30);
                $sheet->getDelegate()->getRowDimension(3)->setRowHeight(20);

                // Styling header (baris 3)
                $highestRow = $sheet->getDelegate()->getHighestRow();
                $highestColumn = $sheet->getDelegate()->getHighestColumn();

                $sheet->getStyle("A3:{$highestColumn}3")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'D9D9D9'],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Border untuk seluruh tabel
                $sheet->getStyle("A3:{$highestColumn}{$highestRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Auto size kolom
                foreach (range('A', $highestColumn) as $col) {
                    $sheet->getDelegate()->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
