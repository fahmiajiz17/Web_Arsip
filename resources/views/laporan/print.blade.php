<!DOCTYPE html>
<html lang="en">

<head>
    {{-- Required meta tags --}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {{-- Title --}}
    <title>Laporan Data Arsip Dokumen</title>
    
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
            <h3 style="margin-bottom:10px">LAPORAN ARSIP DOKUMEN</h3>
            <span>Tanggal {{ Carbon\Carbon::parse(request('tgl_awal'))->translatedFormat('j F Y') . ' s.d. ' . Carbon\Carbon::parse(request('tgl_akhir'))->translatedFormat('j F Y') }}</span>
        @else
            <h3 style="margin-bottom:10px">
                LAPORAN ARSIP DOKUMEN 
                <span style="text-transform:uppercase">{{ $fieldJenis->nama }}</span>
            </h3>
            <span>Tanggal {{ Carbon\Carbon::parse(request('tgl_awal'))->translatedFormat('j F Y') . ' s.d. ' . Carbon\Carbon::parse(request('tgl_akhir'))->translatedFormat('j F Y') }}</span>
        @endif
    </div>

    <hr style="margin-bottom:20px">

    {{-- tabel tampil data --}}
    <table style="width:100%">
        <thead style="background-color: #14438B; color: #ffffff">
            <th>No</th>
            <th>Nama Dokumen</th>
            <th>Nomor Dokumen</th>
            <th>Tanggal Pembuatan</th>
            <th>Jenis Dokumen</th>
        </thead>
        <tbody>
        @php
            $no = 1;
        @endphp
        @forelse ($arsip as $data)
            {{-- jika data ada, tampilkan data --}}
            <tr>
                <td width="30" align="center">{{ $no++ }}</td>
                <td width="200">{{ $data->nama_dokumen }}</td>
                <td width="120">{{ $data->nomor_dokumen }}</td>
                <td width="100">{{ Carbon\Carbon::parse($data->tanggal_pembuatan)->translatedFormat('j F Y') }}</td>
                <td width="150">{{ $data->jenis->nama }}</td>
            </tr>
        @empty
            {{-- jika data tidak ada, tampilkan pesan data tidak tersedia --}}
            <tr>
                <td align="center" colspan="5">Tidak ada data tersedia.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top: 25px; text-align: right">Bandar Lampung, {{ Carbon\Carbon::now()->translatedFormat('j F Y') }}</div>
</body>

</html>
