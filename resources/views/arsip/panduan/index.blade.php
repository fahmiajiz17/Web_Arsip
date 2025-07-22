<x-app-layout>
    <x-slot:title>Panduan Penggunaan</x-slot:title>

    <div class="card">
        <div class="card-body">
            <x-alert></x-alert>

            {{-- Header atas: Pencarian & Aksi --}}
            <div class="d-sm-flex justify-content-between align-items-center flex-wrap mb-4">
                <form action="{{ route('panduan.index') }}" method="GET" class="position-relative mb-3 mb-sm-0">
                    <input type="text" name="search" class="form-control ps-5" value="{{ request('search') }}"
                        placeholder="Pencarian..." autocomplete="off">
                    <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-5 ms-3"></i>
                </form>

                @if (auth()->user()->role == 1)
                    <div class="d-flex gap-2">
                        <a href="{{ route('panduan.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus me-1"></i> Tambah Data
                        </a>
                        <a href="{{ route('panduan.export') }}" class="btn btn-success">
                            <i class="ti ti-file-spreadsheet me-2"></i> Export Excel
                        </a>
                    </div>
                @endif
            </div>

            {{-- Dropdown Pagination --}}
            <form action="{{ route('panduan.index') }}" method="GET" id="perPageForm"
                class="d-flex align-items-center gap-2 mb-3">
                @if (request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                <label for="perPage" class="form-label mb-0">Tampilkan</label>
                <select name="perPage" id="perPage" class="form-select form-select-sm text-center"
                    style="width: 80px;" onchange="document.getElementById('perPageForm').submit()">
                    @foreach ([5, 10, 25, 50, 100] as $limit)
                        <option value="{{ $limit }}" {{ request('perPage', 5) == $limit ? 'selected' : '' }}>
                            {{ $limit }}
                        </option>
                    @endforeach
                </select>
                <span class="mb-0">data per halaman</span>
            </form>




            {{-- tabel tampil data --}}
            <div class="table-responsive border rounded mb-4">
                <table class="table align-middle text-nowrap mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Panduan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($panduan as $data)
                            <tr>
                                <td width="100">{{ ++$i }}</td>
                                <td>{{ $data->nama_dokumen }}</td>
                                <td width="200">
                                    <a href="{{ route('panduan.show', $data->id_panduan) }}"
                                        class="btn btn-warning btn-sm m-1" data-bs-tooltip="tooltip"
                                        data-bs-title="Lihat">
                                        <i class="ti ti-eye"></i>
                                    </a>

                                    @if (auth()->user()->role == 1)
                                        <a href="{{ route('panduan.edit', $data->id_panduan) }}"
                                            class="btn btn-primary btn-sm m-1" data-bs-tooltip="tooltip"
                                            data-bs-title="Ubah">
                                            <i class="ti ti-edit"></i>
                                        </a>

                                        <button type="button" class="btn btn-danger btn-sm m-1" data-bs-toggle="modal"
                                            data-bs-target="#modalHapus{{ $data->id_panduan }}"
                                            data-bs-tooltip="tooltip" data-bs-title="Hapus">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
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
            <div class="pagination-links">{{ $panduan->links() }}</div>
        </div>
    </div>

    {{-- Modals Ditempatkan Di Luar Table --}}
    @foreach ($panduan as $data)
        <div class="modal fade" id="modalHapus{{ $data->id_panduan }}" data-bs-backdrop="static"
            data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalDeleteLabel">
                            <i class="ti ti-trash me-1"></i> Hapus Data Panduan Arsip
                        </h1>
                    </div>
                    <div class="modal-body">
                        <p class="mb-2">
                            Anda yakin ingin menghapus data panduan Arsip <span
                                class="fw-bold">{{ $data->nama_dokumen }}</span>?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('panduan.destroy', $data->id_panduan) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Ya, Hapus!</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

</x-app-layout>
