<x-app-layout>
    <x-slot:title>Klasifikasi Arsip</x-slot:title>

    <div class="card">
        <div class="card-body">
            {{-- menampilkan pesan berhasil --}}
            <x-alert></x-alert>
            @if(session('failures'))
            <div class="alert alert-danger mt-3">
                <ul class="mb-0">
                    @foreach(session('failures') as $failure)
                    <li>{{ $failure }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="d-sm-flex justify-content-between align-items-center flex-wrap mb-4">
                {{-- Form Pencarian --}}
                <form action="{{ route('klasifikasi.index') }}" method="GET" class="position-relative mb-3 mb-sm-0">
                    <input type="text" name="search" class="form-control ps-5" value="{{ request('search') }}"
                        placeholder="Pencarian..." autocomplete="off">
                    <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-5 ms-3"></i>
                </form>

                {{-- Tombol Aksi --}}
                <div class="d-flex gap-2">
                    <a href="{{ route('klasifikasi.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> Tambah Data
                    </a>
                    <!-- Tombol trigger modal -->
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="ti ti-upload me-1"></i> Import Data
                    </button>
                    <a href="{{ route('klasifikasi.export') }}" class="btn btn-success">
                        <i class="ti ti-file-spreadsheet me-2"></i> Export Excel
                    </a>

                </div>
            </div>
            {{-- Form Per Page --}}
            <form action="{{ route('klasifikasi.index') }}" method="GET" id="perPageForm"
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
                            <th>Kode Klasifikasi</th>
                            <th>Jenis Dokumen</th>
                            <th>Retensi Aktif</th>
                            <th>Retensi Inaktif</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($klasifikasi as $data)
                        {{-- jika data ada, tampilkan data --}}
                        <tr>
                            <td width="100">{{ ++$i }}</td>
                            <td>{{ $data->kode_klasifikasi }}</td>
                            <td>{{ $data->jenis_dokumen }}</td>
                            <td>{{ $data->retensi_aktif }} Tahun</td>
                            <td>{{ $data->retensi_inaktif }} Tahun</td>
                            <td width="200">
                                {{-- tombol lihat --}}
                                <a href="{{ route('klasifikasi.show', $data->id_klasifikasi) }}"
                                    class="btn btn-warning btn-sm m-1" data-bs-tooltip="tooltip"
                                    data-bs-title="Lihat">
                                    <i class="ti ti-eye"></i>
                                </a>

                                {{-- button form ubah data --}}
                                <a href="{{ route('klasifikasi.edit', $data->id_klasifikasi) }}"
                                    class="btn btn-primary btn-sm m-1" data-bs-tooltip="tooltip"
                                    data-bs-title="Ubah">
                                    <i class="ti ti-edit"></i>
                                </a>
                                {{-- button modal hapus data 
                                <button type="button" class="btn btn-danger btn-sm m-1" data-bs-toggle="modal" data-bs-target="#modalHapus{{ $data->id }}" data-bs-tooltip="tooltip" data-bs-title="Hapus">
                                <i class="ti ti-trash"></i>
                                </button>
                            </td>
                        </tr>

                        Modal hapus data
                        <div class="modal fade" id="modalHapus{{ $data->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title" id="exampleModalLabel">
                                            <i class="ti ti-trash me-1"></i> Hapus Data Klasifikasi Arsip
                                        </h1>
                                    </div>
                                    <div class="modal-body">
                                        {{-- informasi data yang akan dihapus 
                                        <p class="mb-2">
                                            Anda yakin ingin menghapus data Klasifikasi Arsip <span class="fw-bold mb-2">{{ $data->nama }}</span>?
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                                        {{-- button hapus data 
                                        <form action="{{ route('klasifikasi.destroy', $data->id_klasifikasi) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"> Ya, Hapus! </button>
                                        </form> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
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
            <div class="pagination-links">{{ $klasifikasi->links() }}</div>
        </div>
    </div>

    <!-- Modal Import -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('klasifikasi.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Data Klasifikasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Aturan pengisian -->
                        <div class="mb-3">
                            <p><strong>Aturan Pengisian Data:</strong></p>
                            <ul>
                                <li>Kolom header harus sesuai dengan template (misal: <em>Kode Klasifikasi</em>, <em>Jenis Dokumen</em>, dll)</li>
                                <li>Kolom <em>Retensi Aktif</em> dan <em>Retensi Inaktif</em> harus berisi angka (Dalam Tahun)</li>
                                <li>Kolom yang wajib diisi tidak boleh kosong</li>
                                <li>Pastikan data tidak mengandung karakter khusus yang tidak diizinkan</li>
                                <li>Jika ada kolom <em>Retensi Keterangan</em>, boleh dikosongkan atau diisi dengan teks maksimal 255 karakter</li>
                            </ul>
                        </div>


                        <!-- Contoh isi data -->
                        <div class="mb-3">
                            <p><strong>Contoh Pengisian Data:</strong></p>
                            <div class="table-responsive border rounded">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Kode Klasifikasi</th>
                                            <th>Jenis Dokumen</th>
                                            <th>Klasifikasi Keamanan</th>
                                            <th>Hak Akses</th>
                                            <th>Akses Publik</th>
                                            <th>Retensi Aktif</th>
                                            <th>Retensi Inaktif</th>
                                            <th>Retensi Keterangan</th>
                                            <th>Unit Pengolah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>KLA-001</td>
                                            <td>Surat Masuk</td>
                                            <td>Rahasia</td>
                                            <td>Internal</td>
                                            <td>Tidak</td>
                                            <td>2</td>
                                            <td>3</td>
                                            <td>Dimusnahkan setelah masa retensi</td>
                                            <td>Bagian Umum</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <small class="text-muted">*Retensi Aktif dan Retensi Inaktif diisi dalam tahun (misal: 1, 2, 5)</small>
                        </div>

                        <!-- Link download template -->
                        <div class="mb-3">
                            <p><strong>Download Template:</strong>
                                <a href="{{ route('klasifikasi.template.download') }}" download>
                                    Klik di sini untuk mengunduh template Excel
                                </a>
                            </p>
                        </div>


                        <!-- Keterangan file -->
                        <div class="mb-3">
                            <p><strong>Format File:</strong></p>
                            <ul>
                                <li>Format file harus <strong>.xlsx</strong> (Microsoft Excel Open XML Spreadsheet)</li>
                                <li>Ukuran maksimal file: <strong>2 MB</strong></li>
                                <li>Gunakan template yang sudah disediakan agar format kolom sesuai</li>
                            </ul>
                        </div>


                        <!-- Input file -->
                        <div class="mb-3">
                            <label for="importFile" class="form-label">Pilih file Excel (.xlsx):</label>
                            <input type="file" name="file" id="importFile" class="form-control" accept=".xlsx" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Import</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>