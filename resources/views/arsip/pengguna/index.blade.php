<x-app-layout>
    <x-slot:title>Arsip Dokumen</x-slot:title>

    <div class="card">
        <div class="card-body">
            <div class="mb-4">
                {{-- form pencarian --}}
                <form action="{{ route('arsip.index') }}" method="GET" class="position-relative">
                    <input type="text" name="search" class="form-control ps-5" value="{{ request('search') }}" placeholder="Pencarian..." autocomplete="off">
                    <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-5 ms-3"></i>
                </form>
            </div>

            {{-- tabel tampil data --}}
            <div class="table-responsive border rounded mb-4">
                <table class="table align-middle text-nowrap mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Dokumen</th>
                            <th>Nomor Dokumen</th>
                            <th>Tanggal Pembuatan</th>
                            <th>Jenis Dokumen</th>
                            <th>Lokasi Penyimpanan</th>
                            <th>Filling Cabinet</th>
                            <th>Laci</th>
                            <th>Folder</th>
                            <th>Deskripsi</th>
                            <th>Indeks</th>
                            <th>Tanggal Arsip</th>
                            <th>Dasar Hukum</th>
                            <th>Klasifikasi Arsip</th>
                            <th>Jadwal Retensi Arsip Aktif</th>
                            <th>Jadwal Retensi Arsip Inaktif</th>
                            <th>Penyusutan Akhir</th>
                            <th>Keterangan Penyusutan</th>
                            <th>Keamanan Arsip</th>
                            <th>Status Arsip</th>
                            <th>Batas Status Retensi Aktif</th>
                            <th>Batas Status Retensi Inaktif</th>
                            <th>Vital</th>
                            <th>Terjaga</th>
                            <th>Memori Kolektif Bangsa</th>
                            <th>Waktu Pembuatan Informasi</th>
                            <th>Pembuat Daftar Berkas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($arsip as $data)
                        {{-- jika data ada, tampilkan data --}}
                        <tr>
                            <td width="30">{{ ++$i }}</td>
                            <td width="250">{{ $data->nama_dokumen }}</td>
                            <td width="120">{{ $data->nomor_dokumen }}</td>
                            <td width="120">{{ Carbon\Carbon::parse($data->tanggal_pembuatan)->translatedFormat('j F Y') }}</td>
                            <td width="120">{{ $data->jenis->nama }}</td>
                            <td width="150">{{ $data->lokasi_penyimpanan }}</td>
                            <td width="120">{{ $data->filling_cabinet }}</td>
                            <td width="100">{{ $data->laci }}</td>
                            <td width="120">{{ $data->folder }}</td>
                            <td width="200">{{ $data->deskripsi }}</td>
                            <td width="100">{{ $data->indeks }}</td>
                            <td width="150">{{ Carbon\Carbon::parse($data->tanggal_arsip)->translatedFormat('j F Y') }}</td>
                            <td width="200">{{ $data->dasar_hukum }}</td>
                            <td width="150">{{ $data->klasifikasi_arsip }}</td>
                            <td width="180">{{ Carbon\Carbon::parse($data->jadwal_retensi_arsip_aktif)->translatedFormat('j F Y') }}</td>
                            <td width="180">{{ Carbon\Carbon::parse($data->jadwal_retensi_arsip_inaktif)->translatedFormat('j F Y') }}</td>
                            <td width="150">{{ $data->penyusutan_akhir }}</td>
                            <td width="200">{{ $data->keterangan_penyusutan }}</td>
                            <td width="120">{{ $data->keamanan_arsip }}</td>
                            <td width="120">{{ $data->verifikasi_arsip }}</td>
                            <td width="180">{{ Carbon\Carbon::parse($data->batas_status_retensi_aktif)->translatedFormat('j F Y') }}</td>
                            <td width="180">{{ Carbon\Carbon::parse($data->batas_status_retensi_inaktif)->translatedFormat('j F Y') }}</td>
                            <td width="80">{{ $data->vital }}</td>
                            <td width="80">{{ $data->terjaga }}</td>
                            <td width="200">{{ $data->memori_kolektif_bangsa }}</td>
                            <td width="180">{{ Carbon\Carbon::parse($data->waktu_pembuatan_informasi)->translatedFormat('j F Y') }}</td>
                            <td width="200">{{ $data->pembuat_daftar_berkas }}</td>
                            <td width="100">
                                {{-- button form detail data --}}
                                <a href="{{ route('arsip.show', $data->id) }}" class="btn btn-warning btn-sm m-1" data-bs-tooltip="tooltip" data-bs-title="Detail">
                                    <i class="ti ti-list"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        {{-- jika data tidak ada, tampilkan pesan data tidak tersedia --}}
                        <tr>
                            <td colspan="6">
                                <div class="d-flex justify-content-center align-items-center">
                                    <i class="ti ti-info-circle fs-5 me-2"></i>
                                    <div>Tidak ada data tersedia.</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            {{-- pagination --}}
            <div class="pagination-links">{{ $arsip->links() }}</div>
        </div>
    </div>
</x-app-layout>
