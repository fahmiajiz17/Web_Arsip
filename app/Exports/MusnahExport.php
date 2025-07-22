<?php

namespace App\Exports;

use App\Models\Arsip;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Events\AfterSheet;

class MusnahExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $request;
    protected $rowNumber = 1;


    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $user = Auth::user();
        $today = Carbon::now();

        $query = Arsip::where('status_dokumen', 'Musnah')
            ->whereNotNull('surat_berita_path');

        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_dokumen', 'like', '%' . $search . '%')
                    ->orWhere('nomor_dokumen', 'like', '%' . $search . '%')
                    ->orWhere('indeks', 'like', '%' . $search . '%');
            });
        }

        $sort = $this->request->get('sort', 'asc');
        $query->orderBy('batas_status_retensi_inaktif', $sort);

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
            'Tanggal Dimusnahkan',
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
        $tanggal_musnahkan = Carbon::parse($data->tanggal_musnahkan)->format('Y-m-d');

        $dasarHukum = $data->dasarHukumData ? $data->dasarHukumData->nama_dasar_hukum : '-';

        $klasifikasi = '-';
        if ($data->klasifikasiData) {
            $klasifikasi = $data->klasifikasiData->kode_klasifikasi . ' - ' . $data->klasifikasiData->jenis_dokumen;
        }

        $keywords = $data->kata_kunci;
        if (is_string($keywords)) {
            $keywords = json_decode($keywords, true);
        }
        $kataKunci = is_array($keywords) ? implode(', ', $keywords) : ($keywords ?? '-');

        return [
            $this->rowNumber++,
            $data->nama_dokumen,
            $data->kode_dokumen,
            $tanggal_musnahkan,
            'Musnah',
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // Sisipkan 2 baris di atas header agar header pindah ke baris 3
                $sheet->insertNewRowBefore(1, 2);

                // Judul utama di baris 1
                $sheet->setCellValue('A1', 'ARSIP MUSNAH LLDIKTI WILAYAH IV');
                $sheet->mergeCells('A1:R1');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $sheet->getDelegate()->getRowDimension(1)->setRowHeight(30);
                $sheet->getDelegate()->getRowDimension(3)->setRowHeight(20);

                // Range data (header + data)
                // Header di baris 3, data mulai baris 4
                $highestRow = $sheet->getDelegate()->getHighestRow(); // terakhir baris data
                $highestColumn = $sheet->getDelegate()->getHighestColumn(); // kolom terakhir, misal 'R'

                $tableRange = 'A3:' . $highestColumn . $highestRow;

                // Styling header: bold + bg color abu-abu muda
                $sheet->getStyle('A3:' . $highestColumn . '3')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'D9D9D9'], // abu-abu muda
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

                // Styling seluruh tabel (header + data) dengan border tipis
                $sheet->getStyle($tableRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Wrap text di kolom deskripsi (E), keterangan penyusutan (I), kata kunci (O)
                foreach (['E', 'I', 'O'] as $col) {
                    $sheet->getStyle($col . '4:' . $col . $highestRow)->getAlignment()->setWrapText(true);
                }

                // Alignment kolom tertentu
                // Tanggal Arsip (C), Status (D), Penyusutan Akhir (H), Vital (P), Terjaga (Q), Memori Kolektif Bangsa (R) rata tengah
                foreach (['A','C', 'D', 'H', 'P', 'Q', 'R'] as $col) {
                    $sheet->getStyle($col . '4:' . $col . $highestRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                }

                // Auto size kolom
                foreach (range('A', $highestColumn) as $col) {
                    $sheet->getDelegate()->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
