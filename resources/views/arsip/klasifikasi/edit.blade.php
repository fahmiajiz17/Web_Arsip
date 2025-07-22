<x-app-layout>
    <x-slot:title>Edit Klasifikasi Arsip</x-slot:title>
    <x-slot:breadcrumb>Edit</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">
            {{-- Judul Form --}}
            <x-form-title>
                <i class="ti ti-pencil fs-5 me-2"></i> Edit Data Klasifikasi Arsip
            </x-form-title>

            {{-- Form Edit --}}
            <form action="{{ route('klasifikasi.update', $klasifikasi->id_klasifikasi) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-lg-6">
                        {{-- Kode Klasifikasi --}}
                        <div class="mb-3">
                            <label class="form-label">Kode Klasifikasi <span class="text-danger">*</span></label>
                            <input type="text" name="kode_klasifikasi" class="form-control @error('kode_klasifikasi') is-invalid @enderror" value="{{ old('kode_klasifikasi', $klasifikasi->kode_klasifikasi) }}" autocomplete="off">
                            @error('kode_klasifikasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jenis Dokumen --}}
                        <div class="mb-3">
                            <label class="form-label">Jenis Dokumen <span class="text-danger">*</span></label>
                            <input type="text" name="jenis_dokumen" class="form-control @error('jenis_dokumen') is-invalid @enderror" value="{{ old('jenis_dokumen', $klasifikasi->jenis_dokumen) }}" autocomplete="off">
                            @error('jenis_dokumen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Klasifikasi Keamanan --}}
                        <div class="mb-3">
                            <label class="form-label">Klasifikasi Keamanan <span class="text-danger">*</span></label>
                            <input type="text" name="klasifikasi_keamanan" class="form-control @error('klasifikasi_keamanan') is-invalid @enderror" value="{{ old('klasifikasi_keamanan', $klasifikasi->klasifikasi_keamanan) }}" autocomplete="off">
                            @error('klasifikasi_keamanan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Hak Akses --}}
                        <div class="mb-3">
                            <label class="form-label">Hak Akses <span class="text-danger">*</span></label>
                            <input type="text" name="hak_akses" class="form-control @error('hak_akses') is-invalid @enderror" value="{{ old('hak_akses', $klasifikasi->hak_akses) }}" autocomplete="off">
                            @error('hak_akses')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Akses Publik --}}
                        <div class="mb-3">
                            <label class="form-label">Akses Publik <span class="text-danger">*</span></label>
                            <input type="text" name="akses_publik" class="form-control @error('akses_publik') is-invalid @enderror" value="{{ old('akses_publik', $klasifikasi->akses_publik) }}" autocomplete="off">
                            @error('akses_publik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Retensi Aktif --}}
                        <div class="mb-3">
                            <label class="form-label">Retensi Aktif <span class="text-danger">*</span></label>
                            <input type="number" name="retensi_aktif" class="form-control @error('retensi_aktif') is-invalid @enderror" value="{{ old('retensi_aktif', $klasifikasi->retensi_aktif) }}" autocomplete="off">
                            @error('retensi_aktif')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Retensi Inaktif --}}
                        <div class="mb-3">
                            <label class="form-label">Retensi Inaktif <span class="text-danger">*</span></label>
                            <input type="number" name="retensi_inaktif" class="form-control @error('retensi_inaktif') is-invalid @enderror" value="{{ old('retensi_inaktif', $klasifikasi->retensi_inaktif) }}" autocomplete="off">
                            @error('retensi_inaktif')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Retensi Keterangan --}}
                        <div class="mb-3">
                            <label class="form-label">Retensi Keterangan <span class="text-danger">*</span></label>
                            <input type="text" name="retensi_keterangan" class="form-control @error('retensi_keterangan') is-invalid @enderror" value="{{ old('retensi_keterangan', $klasifikasi->retensi_keterangan) }}" autocomplete="off">
                            @error('retensi_keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Unit Pengolah --}}
                        <div class="mb-3">
                            <label class="form-label">Unit Pengolah <span class="text-danger">*</span></label>
                            <input type="text" name="unit_pengolah" class="form-control @error('unit_pengolah') is-invalid @enderror" value="{{ old('unit_pengolah', $klasifikasi->unit_pengolah) }}" autocomplete="off">
                            @error('unit_pengolah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <x-form-action-buttons>klasifikasi</x-form-action-buttons>
            </form>
        </div>
    </div>
</x-app-layout>
