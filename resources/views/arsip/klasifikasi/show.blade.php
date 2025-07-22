<x-app-layout>
    <x-slot:title>Klasifikasi Arsip</x-slot:title>
    <x-slot:breadcrumb>Detail</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">
            {{-- judul form --}}
            <x-form-title>
                <i class="ti ti-list fs-5 me-2"></i> Detail Klasifikasi Arsip
            </x-form-title>

            {{-- tampilkan detail data --}}
            <div class="table-responsive border rounded mb-4">
                <table class="table align-middle text-nowrap mb-0">
                    <tr>
                        <td width="200">Kode Klasifikasi</td>
                        <td width="10">:</td>
                        <td>{{ $klasifikasi->kode_klasifikasi }}</td>
                    </tr>
                    <tr>
                        <td>Jenis Dokumen</td>
                        <td>:</td>
                        <td>{{ $klasifikasi->jenis_dokumen }}</td>
                    </tr>
                    <tr>
                        <td>Klasifikasi Keamanan</td>
                        <td>:</td>
                        <td>{{ $klasifikasi->klasifikasi_keamanan }}</td>
                    </tr>
                    <tr>
                        <td>Hak Akses</td>
                        <td>:</td>
                        <td>{{ $klasifikasi->hak_akses }}</td>
                    </tr>
                    <tr>
                        <td>Akses Publik</td>
                        <td>:</td>
                        <td>{{ $klasifikasi->akses_publik }}</td>
                    </tr>
                    <tr>
                        <td>Retensi Aktif</td>
                        <td>:</td>
                        <td>{{ $klasifikasi->retensi_aktif }} Tahun</td>
                    </tr>
                    <tr>
                        <td>Retensi Inaktif</td>
                        <td>:</td>
                        <td>{{ $klasifikasi->retensi_inaktif }} Tahun</td>
                    </tr>
                    <tr>
                        <td>Retensi Keterangan</td>
                        <td>:</td>
                        <td>{{ $klasifikasi->retensi_keterangan }}</td>
                    </tr>
                    <tr>
                        <td>Unit Pengolah</td>
                        <td>:</td>
                        <td>{{ $klasifikasi->unit_pengolah }}</td>
                    </tr>
                </table>
            </div>

            {{-- tombol kembali --}}
            <a href="{{ route('klasifikasi.index') }}" class="btn btn-secondary mt-3">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</x-app-layout>