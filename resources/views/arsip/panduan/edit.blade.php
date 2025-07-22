<x-app-layout>
    <x-slot:title>Panduan Penggunaan</x-slot:title>
    <x-slot:breadcrumb>Detail</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">
            <x-form-title>
                <i class="ti ti-list fs-5 me-2"></i> Detail Panduan Penggunaan
            </x-form-title>

            {{-- Form Update Nama Dasar Hukum (input lebih kecil, tombol tetap di kanan) --}}
            <form action="{{ route('panduan.update', $panduan->id_panduan) }}" method="POST"
                class="d-flex align-items-end flex-wrap gap-2 mb-4">
                @csrf
                @method('PUT')

                <div class="flex-grow-1">
                    <label for="nama_dokumen" class="form-label fw-semibold">
                        Nama Dasar Hukum<span class="text-danger">*</span>
                    </label>
                    <input type="text" id="nama_dokumen" name="nama_dokumen" value="{{ $panduan->nama_dokumen }}"
                        class="form-control" placeholder="Masukkan nama dasar hukum" required>
                </div>
                <div>
                    <button type="submit" class="btn btn-secondary mt-2">
                        <i class="ti ti-device-floppy me-1"></i> Simpan
                    </button>
                </div>
            </form>

            {{-- Ambil dan decode file --}}
            @php
                $files = is_string($panduan->dokumen_panduan)
                    ? json_decode($panduan->dokumen_panduan, true)
                    : $panduan->dokumen_panduan;
            @endphp

            {{-- Tabel File --}}
            <div class="table-responsive border rounded mb-4">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 50px;">No</th>
                            <th>Nama File</th>
                            <th class="text-center" style="width: 80px;">Preview</th>
                            <th style="width: 300px;">Ganti File</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($files as $index => $file)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $file }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="modal"
                                        data-bs-target="#previewModal{{ $index }}">
                                        <i class="ti ti-eye"></i>
                                    </button>

                                    <!-- Modal Preview -->
                                    <div class="modal fade" id="previewModal{{ $index }}" tabindex="-1"
                                        aria-labelledby="previewLabel{{ $index }}" aria-hidden="true">
                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="previewLabel{{ $index }}">
                                                        Preview Dokumen: {{ $file }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" style="height: 80vh;">
                                                    <iframe src="{{ asset('storage/panduan/' . $file) }}" width="100%"
                                                        height="100%" class="border rounded"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <form
                                        action="{{ route('panduan.replaceFile', ['id' => $panduan->id_panduan, 'index' => $index]) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="d-flex align-items-center gap-2">
                                            <input type="file" name="file" class="form-control form-control-sm"
                                                required accept="application/pdf">
                                            <button type="submit" class="btn btn-sm btn-primary">Ganti</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            <tr class="collapse" id="preview-{{ $index }}">
                                <td colspan="4">
                                    <iframe src="{{ asset('storage/panduan/' . $file) }}" width="100%" height="600px"
                                        class="border rounded"></iframe>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="form-text text-primary mb-3">
                <div class="badge fw-medium bg-primary-subtle text-primary">Keterangan :</div>
                <div>
                    - Jenis file yang bisa diunggah adalah: pdf. <br>
                    - Ukuran file yang bisa diunggah maksimal 5 MB.
                </div>
            </div>
            {{-- Tombol Kembali --}}
            <a href="{{ route('panduan.index') }}" class="btn btn-primary">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</x-app-layout>
