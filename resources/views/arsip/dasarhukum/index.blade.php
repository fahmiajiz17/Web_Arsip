<x-app-layout>
    <x-slot:title>Dasar Hukum</x-slot:title>

    <div class="card">
        <div class="card-body">
            {{-- menampilkan pesan berhasil --}}
            <x-alert></x-alert>

            <div class="d-sm-flex justify-content-between align-items-center flex-wrap mb-4">
                {{-- Form Pencarian --}}
                <form action="{{ route('dasarhukum.index') }}" method="GET" class="position-relative mb-3 mb-sm-0">
                    <input type="text" name="search" class="form-control ps-5" value="{{ request('search') }}"
                        placeholder="Pencarian..." autocomplete="off">
                    <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-5 ms-3"></i>
                </form>

                {{-- Tombol Aksi --}}
                <div class="d-flex gap-2">
                    <a href="{{ route('dasarhukum.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> Tambah Data
                    </a>
                </div>
            </div>
            {{-- Form Per Page --}}
            <form action="{{ route('dasarhukum.index') }}" method="GET" id="perPageForm"
                class="d-flex align-items-center gap-2 mb-3">
                @if (request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                @if (request('range'))
                    <input type="hidden" name="range" value="{{ request('range') }}">
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
                            <th>Nama Dasar Hukum</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dasar_hukum as $data)
                            <tr>
                                <td width="100">{{ ++$i }}</td>
                                <td>{{ $data->nama_dasar_hukum }}</td>
                                <td width="200">
                                    {{-- tombol lihat --}}
                                    <a href="{{ route('dasarhukum.show', $data->id_dasar_hukum) }}"
                                        class="btn btn-warning btn-sm m-1" data-bs-tooltip="tooltip"
                                        data-bs-title="Lihat">
                                        <i class="ti ti-eye"></i>
                                    </a>

                                    {{-- tombol ubah --}}
                                    <a href="{{ route('dasarhukum.edit', $data->id_dasar_hukum) }}"
                                        class="btn btn-primary btn-sm m-1" data-bs-tooltip="tooltip"
                                        data-bs-title="Ubah">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                </td>
                            </tr>


                        @empty
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
            <div class="pagination-links">
                {{ $dasar_hukum->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
