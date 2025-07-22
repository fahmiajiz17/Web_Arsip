<x-app-layout>
    <x-slot:title>Arsip Dokumen</x-slot:title>

    <div class="card">
        <div class="card-body">
            {{-- menampilkan pesan berhasil --}}
            <x-alert></x-alert>

            <div class="d-sm-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                {{-- Form Pencarian --}}
                <form action="{{ route('arsip.index') }}" method="GET" class="position-relative me-3">
                    <input type="text" name="search" class="form-control ps-5" value="{{ request('search') }}"
                        placeholder="Pencarian..." autocomplete="off">
                    <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-5 ms-3"></i>
                </form>

                {{-- Tombol Tambah Data --}}


                {{-- Filter Tanggal dan Export Excel Berdekatan --}}
                <div class="d-flex gap-2 align-items-center">
                    {{-- Form Filter Tanggal --}}
                    <form action="{{ route('arsip.index') }}" method="GET" class="d-flex align-items-center gap-2">
                        <input type="text" id="filterTanggal" name="range" class="form-control"
                            placeholder="Pilih Rentang Tanggal" value="{{ request('range') }}" readonly>
                        <button type="submit" class="btn btn-primary d-flex align-items-center gap-1">
                            <i class="ti ti-filter"></i> Terapkan
                        </button>
                    </form>
                    <div class="d-flex gap-2">
                        @if (auth()->user()->role == 4)
                        <a href="{{ route('arsip.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus me-2"></i> Tambah Data
                        </a>
                        @endif
                    </div>

                    {{-- Tombol Export Excel --}}
                    <a href="{{ route('arsip.export') }}" class="btn btn-success d-flex align-items-center gap-1">
                        <i class="ti ti-file-spreadsheet"></i> Export Excel
                    </a>
                </div>
            </div>

            {{-- Form Per Page --}}
            <form action="{{ route('arsip.index') }}" method="GET" id="perPageForm"
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

            <div class="table-responsive border rounded mb-4">
                <table class="table align-middle text-nowrap mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>
                                <a href="{{ route('arsip.index', array_merge(request()->all(), ['sort_by' => 'nama_dokumen', 'sort' => request('sort') === 'asc' ? 'desc' : 'asc'])) }}"
                                    class="text-decoration-none text-dark">
                                    Nama Dokumen
                                    @if (request('sort_by') === 'nama_dokumen')
                                    @if (request('sort') === 'asc')
                                    <i class="ti ti-arrow-up"></i>
                                    @else
                                    <i class="ti ti-arrow-down"></i>
                                    @endif
                                    @endif
                                </a>
                            </th>

                            <th>Kode Dokumen</th>
                            <th>
                                <a href="{{ route('arsip.index', array_merge(request()->all(), ['sort' => request('sort') === 'desc' ? 'asc' : 'desc'])) }}"
                                    class="text-decoration-none text-dark">
                                    Tanggal Dokumen
                                    @if (request('sort') === 'desc')
                                    <i class="ti ti-arrow-down"></i>
                                    @else
                                    <i class="ti ti-arrow-up"></i>
                                    @endif
                                </a>
                            </th>

                            @if (auth()->user()->role == 2 || auth()->user()->role == 1 || auth()->user()->role == 3 )
                            <th>
                                <a href="{{ route('arsip.index', array_merge(request()->all(), ['sort_by' => 'nama_tim_kerja', 'sort' => request('sort') === 'asc' ? 'desc' : 'asc'])) }}"
                                    class="text-decoration-none text-dark">
                                    Tim Kerja
                                    @if (request('sort_by') === 'nama_tim_kerja')
                                    @if (request('sort') === 'asc')
                                    <i class="ti ti-arrow-up"></i>
                                    @else
                                    <i class="ti ti-arrow-down"></i>
                                    @endif
                                    @endif
                                </a>
                            </th>

                            @endif
                            @if (auth()->user()->role == 2 || auth()->user()->role == 3)
                            <th>Detail</th>
                            @endif

                            @if (auth()->user()->role == 4)
                            <th>Status Dokumen</th>
                            @endif

                            @if (auth()->user()->role == 1 || auth()->user()->role == 4)
                            <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($arsip as $data)
                        <tr>
                            <td width="30">{{ ++$i }}</td>
                            <td width="250">{{ $data->nama_dokumen }}</td>
                            <td width="120">{{ $data->kode_dokumen }}</td>
                            <td width="120"> {{ \Carbon\Carbon::parse($data->tanggal_arsip)->format('d-m-Y') }}</td>
                            <td width="120">
                                {{ $data->user->nama_user }}
                            </td>
                            @if (auth()->user()->role == 2 || (auth()->user()->role == 3))
                            <td width="120"><a href="{{ route('arsip.show', $data->nomor_dokumen) }}"
                                    class="btn btn-warning btn-sm m-1" data-bs-tooltip="tooltip"
                                    data-bs-title="Detail">
                                    <i class="ti ti-eye"></i>
                                </a></td>
                            @endif
                            @if (auth()->user()->role == 1)
                            <td width="100">
                                <a href="{{ route('arsip.show', $data->nomor_dokumen) }}"
                                    class="btn btn-warning btn-sm m-1" data-bs-tooltip="tooltip"
                                    data-bs-title="Tinjau dan Verifikasi">
                                    <i class="ti ti-eye-edit"></i>
                                </a>
                            </td>
                            @endif
                            @if (auth()->user()->role == 4)
                            <td width='100'>
                                @if ($data->verifikasi_arsip === 'Disetujui')
                                <a href="{{ route('arsip.show', $data->nomor_dokumen) }}"
                                    class="btn btn-warning btn-sm m-1" data-bs-tooltip="tooltip"
                                    data-bs-title="Detail">
                                    <i class="ti ti-eye"></i>
                                </a>
                                @else
                                <a href="{{ route('arsip.show', $data->nomor_dokumen) }}"
                                    class="btn btn-danger btn-sm m-1" data-bs-tooltip="tooltip"
                                    data-bs-title="Detail">
                                    <i class="ti ti-eye"></i>
                                </a>
                                @endif

                                @if ($data->verifikasi_arsip !== 'Disetujui')
                                <a href="{{ route('arsip.edit', $data->nomor_dokumen) }}"
                                    class="btn btn-primary btn-sm m-1" data-bs-tooltip="tooltip"
                                    data-bs-title="Ubah">
                                    <i class="ti ti-edit"></i>
                                </a>
                                @endif
                            </td>
                            @endif

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
            <div class="pagination-links">{{ $arsip->links() }}</div>

            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                {{-- Select Per Page di sebelah kiri --}}
                <form action="{{ route('arsip.index') }}" method="GET"
                    class="d-flex align-items-center mb-2 mb-md-0">
                    {{-- Bawa nilai pencarian (jika ada) --}}
                    @if (request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- Date Range Picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        flatpickr("#filterTanggal", {
            mode: "range",
            dateFormat: "d-m-Y",
            altInput: true,
            altFormat: "d M Y",
            allowInput: true
        });
    </script>

</x-app-layout>