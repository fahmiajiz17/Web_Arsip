<x-app-layout>
    <x-slot:title>Arsip Musnah</x-slot:title>

    <div class="card">
        <div class="card-body">
            <x-alert></x-alert>

            <div class="d-sm-flex flex-sm-row-reverse justify-content-between align-items-center mb-4">
                <div class="d-flex gap-2 mb-3 mb-sm-0">
                    {{-- Form Filter Rentang Tanggal --}}
                    <form action="{{ route('musnah.index') }}" method="GET" class="d-flex align-items-center gap-2">
                        <input type="text" id="filterTanggal" name="range" class="form-control"
                            placeholder="Pilih Rentang Tanggal" value="{{ request('range') }}" autocomplete="off"
                            style="min-width: 220px;">
                        <button type="submit" class="btn btn-primary d-flex align-items-center gap-1">
                            <i class="ti ti-filter"></i> Terapkan
                        </button>
                    </form>

                    {{-- Tombol Export Excel --}}
                    <a href="{{ route('musnah.export', request()->query()) }}" class="btn btn-success">
                        <i class="ti ti-file-spreadsheet me-2"></i> Export Excel
                    </a>
                </div>

                {{-- Form Pencarian --}}
                <form action="{{ route('musnah.index') }}" method="GET" class="position-relative">
                    <input type="text" name="search" class="form-control ps-5" value="{{ request('search') }}"
                        placeholder="Pencarian..." autocomplete="off">
                    <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-5 ms-3"></i>
                </form>
            </div>

            {{-- Per Page Selector --}}
            <form action="{{ route('musnah.index') }}" method="GET" class="d-flex align-items-center gap-2 mb-3">
                @if (request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                @if (request('range'))
                <input type="hidden" name="range" value="{{ request('range') }}">
                @endif
                @if (request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif

                <label for="perPage" class="form-label mb-0">Tampilkan</label>
                <select name="perPage" id="perPage" class="form-select form-select-sm text-center"
                    style="width: 70px;" onchange="this.form.submit()">
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
                            <th>Kode</th>
                            <th>Nama Dokumen</th>
                            <th>
                                <a href="{{ route('musnah.index', array_merge(request()->all(), ['sort' => request('sort') === 'desc' ? 'asc' : 'desc'])) }}"
                                    class="text-decoration-none text-dark">
                                    Tanggal Dimusnahkan
                                    @if (request('sort') === 'desc')
                                    <i class="ti ti-arrow-down"></i>
                                    @else
                                    <i class="ti ti-arrow-up"></i>
                                    @endif
                                </a>
                            </th>
                            <th>Status Arsip</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($musnah as $data)
                        <tr>
                            <td width="30">{{ ++$i }}</td>
                            <td width="100">{{ $data->kode_dokumen }}</td>
                            <td>{{ $data->nama_dokumen }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->tanggal_musnahkan)->format('d-m-Y') ?? '-' }}</td>
                            <td>
                                <span class="badge bg-danger">Musnah</span>
                            </td>
                            <td width="120">
                                <a href="{{ route('musnah.show', $data->nomor_dokumen) }}"
                                    class="btn btn-warning btn-sm m-1" data-bs-tooltip="tooltip"
                                    data-bs-title="Detail">
                                    <i class="ti ti-eye"></i>
                                </a>

                                @if ($data->surat_berita_path)
                                <button class="btn btn-info btn-sm m-1" data-bs-toggle="modal"
                                    data-bs-target="#modalSurat{{ $data->kode_dokumen }}">
                                    <i class="ti ti-mail"></i>
                                </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                Data tidak ada.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="pagination-links">
                {{ $musnah->links() }}
            </div>
        </div>
    </div>

    {{-- Modal Surat Berita Pemusnahan --}}
    @foreach ($musnah as $data)
    @if ($data->surat_berita_path)
    <div class="modal fade" id="modalSurat{{ $data->kode_dokumen }}" tabindex="-1"
        aria-labelledby="modalSuratLabel{{ $data->kode_dokumen }}" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSuratLabel{{ $data->kode_dokumen }}">Surat Berita
                        Pemusnahan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <embed src="{{ asset('storage/' . $data->surat_berita_path) }}" type="application/pdf"
                        width="100%" height="600px" />
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach

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