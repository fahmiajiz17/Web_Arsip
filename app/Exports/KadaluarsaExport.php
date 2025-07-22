<?php

namespace App\Exports;

use App\Models\Arsip;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class KadaluarsaExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithCustomStartCell
{
    private int $counter = 0;

    public function collection()
    {
        $user = Auth::user();

        $query = Arsip::with(['dasarHukumData', 'klasifikasiData'])
            ->where('status_dokumen', 'Inaktif');

        if (!in_array($user->role, [1, 2, 3])) {
            $query->where('dibuat_oleh', $user->id);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Dokumen',
            'Kode Dokumen',
            'Tanggal Arsip',
            'Status',
            'Deskripsi Arsip',
            'Dasar Hukum',
            'Klasifikasi',
            'Penyusutan Akhir',
            'Keterangan Penyusutan',
            'Keamanan Arsip',
            'Lokasi Penyimpanan',
            'Filling Cabinet',
            'Laci',
            'Folder',
            'Kata Kunci',
            'Vital',
            'Terjaga',
            'Memori Kolektif Bangsa',
        ];
    }

    public function map($data): array
    {
        $this->counter++;

        $tanggalArsip = Carbon::parse($data->tanggal_pembuatan)->format('Y-m-d') . ' s.d ' .
            Carbon::parse($data->batas_status_retensi_aktif)->format('Y-m-d');

        $dasarHukum = $data->dasarHukumData?->nama_dasar_hukum ?? '-';

        $klasifikasi = $data->klasifikasiData
            ? $data->klasifikasiData->kode_klasifikasi . ' - ' . $data->klasifikasiData->jenis_dokumen
            : '-';

        $keywords = $data->kata_kunci;
        if (is_string($keywords)) {
            $keywords = json_decode($keywords, true);
        }
        $kataKunci = is_array($keywords) ? implode(', ', $keywords) : ($keywords ?? '-');

        return [
            $this->counter,
            $data->nama_dokumen,
            $data->kode_dokumen,
            $tanggalArsip,
            'Inaktif',
            $data->deskripsi_arsip,
            $dasarHukum,
            $klasifikasi,
            $data->penyusutan_akhir,
            $data->keterangan_penyusutan,
            $data->keamanan_arsip,
            $data->lokasi_penyimpanan,
            $data->filling_cabinet,
            $data->laci,
            $data->folder,
            $kataKunci,
            $data->vital,
            $data->terjaga,
            $data->memori_kolektif_bangsa,
        ];
    }

    public function startCell(): string
    {
        return 'A2'; // Header di baris 2, data mulai baris 3
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $headingCount = count($this->headings());
                $lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($headingCount);

                // Judul di baris 1 tanpa insert row
                $sheet->setCellValue('A1', 'ARSIP INAKTIF LLDIKTI WILAYAH IV');
                $sheet->mergeCells("A1:{$lastColumn}1");
                $sheet->getStyle("A1")->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(30);

                // Styling header di baris 2
                $sheet->getStyle("A2:{$lastColumn}2")->applyFromArray([
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

                $highestRow = $sheet->getHighestRow();

                // Border seluruh area header + data
                $sheet->getStyle("A2:{$lastColumn}{$highestRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Wrap kolom tertentu
                foreach (['F', 'J', 'P'] as $col) {
                    $sheet->getStyle("{$col}3:{$col}{$highestRow}")
                        ->getAlignment()->setWrapText(true);
                }

                // Center kolom tertentu
                foreach (['D', 'E', 'I', 'Q', 'R', 'S'] as $col) {
                    $sheet->getStyle("{$col}3:{$col}{$highestRow}")
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                }

                // Auto size semua kolom
                foreach (range('A', $lastColumn) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
