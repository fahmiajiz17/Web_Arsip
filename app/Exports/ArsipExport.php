<?php

namespace App\Exports;

use App\Models\Arsip;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ArsipExport implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
{
    protected $user;

    public function __construct($user = null)
    {
        $this->user = $user ?: Auth::user();
    }

    public function collection()
    {
        $today = Carbon::now()->toDateString();

        $query = Arsip::with(['dasarHukumData', 'klasifikasiDataExport', 'user', 'disetujuiOlehUser'])
            ->where(function ($q) {
                $q->where('status_dokumen', 'Aktif')
                    ->orWhere('verifikasi_arsip', 'Verifikasi');
            });


        if (!in_array($this->user->role, [1, 2, 3])) {
            $query->where('dibuat_oleh', $this->user->id);
        }

        $arsips = $query->orderBy('tanggal_arsip', 'desc')->get();

        return $arsips->values()->map(function ($item, $index) {
            return array_merge([
                'no' => $index + 1,
            ], [
                'nama_dokumen' => $item->nama_dokumen,
                'kode_dokumen' => $item->kode_dokumen,
                'tanggal_arsip' => $item->tanggal_arsip,
                'deskripsi_arsip' => $item->deskripsi_arsip,
                'dasar_hukum' => optional($item->dasarHukumData)->nama_dasar_hukum ?? '-',
                'klasifikasi' => optional($item->klasifikasiData)
                    ? optional($item->klasifikasiData)->kode_klasifikasi . ' - ' . optional($item->klasifikasiData)->jenis_dokumen
                    : '-',
                'jadwal_retensi_arsip_aktif' => $item->jadwal_retensi_arsip_aktif . ' Tahun',
                'batas_status_retensi_aktif' => $item->batas_status_retensi_aktif,
                'jadwal_retensi_arsip_inaktif' => $item->jadwal_retensi_arsip_inaktif . ' Tahun',
                'batas_status_retensi_inaktif' => $item->batas_status_retensi_inaktif,
                'penyusutan_akhir' => $item->penyusutan_akhir,
                'keterangan_penyusutan' => $item->keterangan_penyusutan,
                'vital' => $item->vital,
                'terjaga' => $item->terjaga,
                'keamanan_arsip' => $item->keamanan_arsip,
                'lokasi_penyimpanan' => $item->lokasi_penyimpanan,
                'filling_cabinet' => $item->filling_cabinet,
                'laci' => $item->laci,
                'folder' => $item->folder,
                'kata_kunci' => is_array($item->kata_kunci)
                    ? implode(', ', $item->kata_kunci)
                    : (is_string($item->kata_kunci) && str_starts_with($item->kata_kunci, '[')
                        ? implode(', ', json_decode($item->kata_kunci, true))
                        : $item->kata_kunci),
                'verifikasi_arsip' => $item->verifikasi_arsip,
                'dibuat_oleh' => optional($item->user)->nama_user ?? '-',
                'disetujui_oleh' => optional($item->disetujuiOlehUser)->nama_user ?? '-',
            ]);
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Dokumen',
            'Kode Dokumen',
            'Tanggal Arsip',
            'Deskripsi Arsip',
            'Dasar Hukum',
            'Klasifikasi',
            'Jadwal Retensi Arsip Aktif',
            'Tanggal Batas Status Retensi Aktif',
            'Jadwal Retensi Arsip Inaktif',
            'Tanggal Batas Status Retensi Inaktif',
            'Penyusutan Akhir',
            'Keterangan Penyusutan',
            'Vital',
            'Terjaga',
            'Keamanan Arsip',
            'Lokasi Penyimpanan',
            'Filling Cabinet',
            'Laci',
            'Folder',
            'Kata Kunci',
            'Verifikasi Arsip',
            'Dibuat Oleh',
            'Disetujui Oleh',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->insertNewRowBefore(1, 1);
                $sheet->setCellValue('A1', 'DATA ARSIP LLDIKTI 4');
                $sheet->mergeCells('A1:X1');

                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 20,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $sheet->getStyle('A2:X2')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'bottom' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                $lastRow = $sheet->getHighestRow();
                $sheet->getStyle("A2:X{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                foreach (range('A', 'X') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
