<?php

namespace App\Exports;

use App\Models\PanduanPenggunaan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PanduanExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $no = 1;

    public function collection()
    {
        return PanduanPenggunaan::select('nama_dokumen', 'dokumen_panduan')->get();
    }

    public function map($row): array
    {
        $fileList = json_decode($row->dokumen_panduan, true); // parsing json array

        if (is_array($fileList)) {
            // ambil hanya nama file tanpa angka prefix
            $cleanNames = array_map(function ($file) {
                return preg_replace('/^\d+_/', '', $file); // hapus angka dan underscore di awal
            }, $fileList);

            $fileText = implode(", ", $cleanNames); // gabungkan jadi 1 baris
        } else {
            $fileText = '-';
        }

        return [
            $this->no++,
            $row->nama_dokumen,
            $fileText,
        ];
    }


    public function headings(): array
    {
        return ['No', 'Nama Dokumen', 'Nama File Dokumen'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // Sisipkan 2 baris di atas header agar header pindah ke baris 3
                $sheet->insertNewRowBefore(1, 2);

                // Judul utama di baris 1
                $sheet->setCellValue('A1', 'PANDUAN PENGGUNAAN SISTEM PENGELOLAAN ARSIP DIGITAL LLDIKTI4');
                $sheet->mergeCells('A1:C1');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $sheet->getDelegate()->getRowDimension(1)->setRowHeight(30);
                $sheet->getDelegate()->getRowDimension(3)->setRowHeight(20);

                // Styling header
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

                // Border seluruh tabel
                $sheet->getStyle("A3:{$highestColumn}{$highestRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Auto size
                foreach (range('A', $highestColumn) as $col) {
                    $sheet->getDelegate()->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
