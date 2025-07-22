<x-app-layout>
    <x-slot:title>Arsip Inaktif</x-slot:title>

    <div class="card">
        <div class="card-body">
            <x-alert></x-alert>

            <div class="d-sm-flex flex-sm-row-reverse justify-content-between align-items-center mb-4">
                <div class="d-flex gap-2 mb-3 mb-sm-0">
                    <form action="{{ route('kadaluarsa.index') }}" method="GET" class="d-flex align-items-center gap-2">
                        @if (request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if (request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif
                        @if (request('perPage'))
                        <input type="hidden" name="perPage" value="{{ request('perPage') }}">
                        @endif

                        <input type="text" id="filterTanggal" name="range" class="form-control"
                            placeholder="Pilih Rentang Tanggal" value="{{ request('range') }}" readonly>
                        <button type="submit" class="btn btn-primary d-flex align-items-center gap-1">
                            <i class="ti ti-filter"></i> Terapkan
                        </button>
                    </form>


                    <a href="{{ route('kadaluarsa.export', request()->query()) }}" class="btn btn-success">
                        <i class="ti ti-file-spreadsheet me-2"></i> Export Excel
                    </a>

                </div>

                <form action="{{ route('kadaluarsa.index') }}" method="GET" class="position-relative">
                    @if (request('range'))
                    <input type="hidden" name="range" value="{{ request('range') }}">
                    @endif
                    @if (request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                    @if (request('perPage'))
                    <input type="hidden" name="perPage" value="{{ request('perPage') }}">
                    @endif

                    <input type="text" name="search" class="form-control ps-5" value="{{ request('search') }}"
                        placeholder="Pencarian ..." autocomplete="off">
                    <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-5 ms-3"></i>
                </form>

            </div>

            {{-- Per Page Selector --}}
            <form action="{{ route('kadaluarsa.index') }}" method="GET" class="d-flex align-items-center gap-2 mb-3">
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
                    <option value="{{ $limit }}" {{ request('perPage', 10) == $limit ? 'selected' : '' }}>
                        {{ $limit }}
                    </option>
                    @endforeach
                </select>
                <span class="mb-0">data per halaman</span>
            </form>

            {{-- Form Pemusnahan --}}
            <form id="formMusnahkan" action="{{ route('kadaluarsa.musnahkanManual') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="table-responsive border rounded mb-4">
                    <table class="table align-middle text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                @if (auth()->user()->role == 1)
                                <th><input type="checkbox" id="checkAll"></th>
                                @endif
                                <th>Kode</th>
                                <th>Nama Dokumen</th>
                                <th>
                                    <a href="{{ route('kadaluarsa.index', array_merge(request()->all(), ['sort' => request('sort') === 'desc' ? 'asc' : 'desc'])) }}"
                                        class="text-decoration-none text-dark">
                                        Kurun Waktu
                                        @if (request('sort') === 'desc')
                                        <i class="ti ti-arrow-down"></i>
                                        @else
                                        <i class="ti ti-arrow-up"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>Status Arsip</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kadaluarsa as $data)
                            <tr>
                                <td width="30">{{ ++$i }}</td>
                                @if (auth()->user()->role == 1)
                                <td><input type="checkbox" name="dokumen_ids[]"
                                        value="{{ $data->kode_dokumen }}" class="checkItem"></td>
                                @endif
                                <td width="100">{{ $data->kode_dokumen }}</td>
                                <td>{{ $data->nama_dokumen }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($data->tanggal_arsip)->format('d-m-Y') }}
                                    s.d
                                    {{ \Carbon\Carbon::parse($data->batas_status_retensi_aktif)->format('d-m-Y') }}
                                </td>
                                <td>
                                    <span class="badge bg-danger">{{ $data->status_dokumen }}</span>
                                </td>
                                <td width="80">
                                    <a href="{{ route('kadaluarsa.show', $data->nomor_dokumen) }}"
                                        class="btn btn-warning btn-sm m-1" data-bs-tooltip="tooltip"
                                        data-bs-title="Detail">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <i class="ti ti-info-circle fs-5 me-2"></i>
                                        Tidak ada data arsip kadaluarsa.
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>


                {{-- Pagination links --}}
                <div class="pagination-links">
                    {{ $kadaluarsa->links() }}
                </div>

                @if (auth()->user()->role == 1)
                <div class="mb-3">
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                        data-bs-target="#modalMusnahkan" id="btnMusnahkan" disabled>
                        Musnahkan Arsip Terpilih
                    </button>
                </div>
                @endif

                {{-- Modal Upload Surat Musnah --}}
                <div class="modal fade" id="modalMusnahkan" tabindex="-1" aria-labelledby="modalMusnahkanLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Unggah Surat Berita Musnah</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="surat_berita" class="form-label">Upload Surat (PDF)</label>
                                    <input type="file" name="surat_berita" id="surat_berita" class="form-control"
                                        accept=".pdf" required>
                                    <small id="fileSizeInfo" class="form-text text-muted mt-1"></small>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_musnahkan" class="form-label">Tanggal Pemusnahan</label>
                                    <input type="date" name="tanggal_musnahkan" id="tanggal_musnahkan" class="form-control" required
                                        max="{{ date('Y-m-d') }}">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">Musnahkan Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<!-- Date Range Picker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    // Tampilkan ukuran file setelah diupload
    document.getElementById('surat_berita').addEventListener('change', function() {
        const file = this.files[0];
        const fileSizeInfo = document.getElementById('fileSizeInfo');

        if (file) {
            const sizeInKB = file.size / 1024;
            const sizeText = sizeInKB < 1024 ?
                `${sizeInKB.toFixed(2)} KB` :
                `${(sizeInKB / 1024).toFixed(2)} MB`;

            fileSizeInfo.textContent = `Ukuran file: ${sizeText}`;
        } else {
            fileSizeInfo.textContent = '';
        }
    });
    flatpickr("#filterTanggal", {
        mode: "range",
        dateFormat: "d-m-Y",
        altInput: true,
        altFormat: "d M Y",
        allowInput: true
    });

    // Checkbox Logic
    const checkAll = document.getElementById('checkAll');
    const checkboxes = document.querySelectorAll('.checkItem');
    const btnMusnahkan = document.getElementById('btnMusnahkan');

    checkAll.addEventListener('change', function() {
        checkboxes.forEach(c => c.checked = checkAll.checked);
        btnMusnahkan.disabled = !checkAll.checked && !Array.from(checkboxes).some(c => c.checked);
    });

    checkboxes.forEach(c => {
        c.addEventListener('change', () => {
            btnMusnahkan.disabled = !Array.from(checkboxes).some(c => c.checked);
        });
    });
</script>