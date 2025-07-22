<!DOCTYPE html>
<html lang="en">

<head>
    {{-- Required meta tags --}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {{-- Title --}}
    <title>Laporan Data Arsip Dokumen Kadaluarsa</title>
    
    {{-- custom style --}}
    <style type="text/css">
        body,
        html {
            font-family: sans-serif;
            font-size: 14px;
            color: #29343d;
        }

        table, th, td {
            border: 1px solid #dee2e6;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px 5px;
        }

        hr {
            color: #dee2e6;
        }
    </style>
</head>

<body>
    {{-- judul laporan --}}
    <div style="text-align:center;margin-bottom:20px">
        @if (request('jenis') == 'Semua')
            <h3 style="margin-bottom:10px">LAPORAN ARSIP DOKUMEN KADALUARSA</h3>
            <span>Tanggal {{ Carbon\Carbon::parse(request('tgl_awal'))->translatedFormat('j F Y') . ' s.d. ' . Carbon\Carbon::parse(request('tgl_akhir'))->translatedFormat('j F Y') }}</span>
        @else
            <h3 style="margin-bottom:10px">
                LAPORAN ARSIP DOKUMEN KADALUARSA
                <span style="text-transform:uppercase">{{ $fieldJenis->nama }}</span>
            </h3>
            <span>Tanggal {{ Carbon\Carbon::parse(request('tgl_awal'))->translatedFormat('j F Y') . ' s.d. ' . Carbon\Carbon::parse(request('tgl_akhir'))->translatedFormat('j F Y') }}</span>
        @endif
    </div>

    <hr style="margin-bottom:20px">

    {{-- form pencarian --}}
    <form action="{{ route('print.blade') }}" method="GET" class="position-relative">
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
                            <th>Status</th>
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
                            <td width="100">
                                {{-- button form detail data --}}
                                <a href="{{ route('arsip.show', $data->id) }}" class="btn btn-warning btn-sm m-1" data-bs-tooltip="tooltip" data-bs-title="Detail">
                                    <i class="ti ti-list"></i>
                                </a>
                                {{-- button form ubah data --}}
                                <a href="{{ route('arsip.edit', $data->id) }}" class="btn btn-primary btn-sm m-1" data-bs-tooltip="tooltip" data-bs-title="Ubah">
                                    <i class="ti ti-edit"></i>
                                </a>
                                {{-- button modal hapus data --}}
                                <button type="button" class="btn btn-danger btn-sm m-1" data-bs-toggle="modal" data-bs-target="#modalHapus{{ $data->id }}" data-bs-tooltip="tooltip" data-bs-title="Hapus"> 
                                    <i class="ti ti-trash"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- Modal hapus data --}}
                        <div class="modal fade" id="modalHapus{{ $data->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title" id="exampleModalLabel">
                                            <i class="ti ti-trash me-1"></i> Hapus Data Arsip Dokumen
                                        </h1>
                                    </div>
                                    <div class="modal-body">
                                        {{-- informasi data yang akan dihapus --}}
                                        <p class="mb-2">
                                            Anda yakin ingin menghapus data arsip dokumen <span class="fw-bold mb-2">{{ $data->nama_dokumen }}</span>?
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                                        {{-- button hapus data --}}
                                        <form action="{{ route('arsip.destroy', $data->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"> Ya, Hapus! </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty

    <div style="margin-top: 25px; text-align: right">Bandung, {{ Carbon\Carbon::now()->translatedFormat('j F Y') }}</div>
</body>

</html>
