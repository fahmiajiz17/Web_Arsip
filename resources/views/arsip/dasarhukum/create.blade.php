<x-app-layout>
    <x-slot:title>Dasar Hukum</x-slot:title>
    <x-slot:breadcrumb>Tambah</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">
            {{-- Judul Form --}}
            <x-form-title>
                <i class="ti ti-pencil-plus fs-5 me-2"></i> Tambah Data Dasar Hukum
            </x-form-title>

            {{-- Form Tambah Data --}}
            <form action="{{ route('dasarhukum.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <label class="form-label">Nama Dasar Hukum <span class="text-danger">*</span></label>
                        <input type="text" name="nama_dasar_hukum"
                            class="form-control @error('nama_dasar_hukum') is-invalid @enderror"
                            value="{{ old('nama_dasar_hukum') }}" autocomplete="off">
                        @error('nama_dasar_hukum')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-lg-6 mb-3">
                        <label class="form-label">Dokumen Elektronik <span class="text-danger">*</span></label>
                        <input type="file" accept=".pdf" name="dokumen_dasar_hukum" id="dokumen_dasar_hukum"
                            class="form-control @error('dokumen_dasar_hukum') is-invalid @enderror" autocomplete="off">
                        @error('dokumen_dasar_hukum')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="form-text text-primary mt-1">
                            <small id="fileSizeInfo" class="form-text text-muted"></small>
                            <div class="mt-1">
                                <div class="badge fw-medium bg-primary-subtle text-primary mt-2">Keterangan :</div>
                                <div class="mt-1">
                                    - Jenis file yang bisa diunggah adalah: pdf. <br>
                                    - Ukuran file maksimal: 5 MB.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <x-form-action-buttons>dasar hukum</x-form-action-buttons>
            </form>
        </div>
    </div>
</x-app-layout>

{{-- SCRIPT: Menampilkan ukuran file --}}
<script>
    document.getElementById('dokumen_dasar_hukum').addEventListener('change', function() {
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
</script>
