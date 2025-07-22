<x-app-layout>
    <x-slot:title>Profil Instansi</x-slot:title>
    <x-slot:breadcrumb>Ubah</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">
            {{-- Judul form --}}
            <x-form-title>
                <i class="ti ti-edit fs-5 me-2"></i> Ubah Halaman Dashboard Login
            </x-form-title>

            {{-- Form ubah data --}}
            <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-xl-7 pe-xl-5">
                        {{-- Nama Aplikasi --}}
                        <div class="mb-3">
                            <label class="form-label">Nama Aplikasi <span class="text-danger">*</span></label>
                            <input type="text" name="nama_aplikasi" class="form-control @error('nama_aplikasi') is-invalid @enderror" value="{{ old('nama_aplikasi', $profil->nama_aplikasi) }}" autocomplete="off">
                            @error('nama_aplikasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kepanjangan Nama Aplikasi --}}
                        <div class="mb-3">
                            <label class="form-label">Kepanjangan Nama Aplikasi <span class="text-danger">*</span></label>
                            <textarea name="kepanjangan_aplikasi" rows="2" class="form-control @error('kepanjangan_aplikasi') is-invalid @enderror" autocomplete="off">{{ old('kepanjangan_aplikasi', $profil->kepanjangan_aplikasi) }}</textarea>
                            @error('kepanjangan_aplikasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Copyright --}}
                        <div class="mb-3">
                            <label class="form-label">Copyright <span class="text-danger">*</span></label>
                            <input type="text" name="nama_copyright" class="form-control @error('nama_copyright') is-invalid @enderror" value="{{ old('nama_copyright', $profil->nama_copyright) }}" autocomplete="off">
                            @error('nama_copyright')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-xl-5">
                        {{-- Logo Kerjasama --}}
                        <div class="mb-4">
                            <label class="form-label">Logo Kerjasama</label>
                            <input type="file" accept=".jpg,.jpeg,.png" name="logo_kerjasama" class="form-control @error('logo_kerjasama') is-invalid @enderror" onchange="previewImage(event, 'previewLogoKerjasama')">
                            @error('logo_kerjasama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="mt-3">
                                <img id="previewLogoKerjasama" src="{{ $profil->logo_kerjasama ? asset('storage/logo/' . $profil->logo_kerjasama) : asset('images/default-logo.png') }}" class="img-thumbnail rounded-4 shadow-sm" width="180" alt="Logo Kerjasama">
                            </div>
                            <div class="form-text text-primary mt-3 mb-0">
                                <div class="badge fw-medium bg-primary-subtle text-primary">Keterangan :</div>
                                <div>
                                    - Jenis file yang bisa diunggah: jpg, jpeg, png. <br>
                                    - Ukuran maksimal 1 MB.
                                </div>
                            </div>
                        </div>

                        {{-- Logo Instansi --}}
                        <div class="mb-4">
                            <label class="form-label">Logo Instansi</label>
                            <input type="file" accept=".jpg,.jpeg,.png" name="logo_instansi" class="form-control @error('logo_instansi') is-invalid @enderror" onchange="previewImage(event, 'previewLogoInstansi')">
                            @error('logo_instansi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="mt-3">
                                <img id="previewLogoInstansi" src="{{ $profil->logo_instansi ? asset('storage/logo/' . $profil->logo_instansi) : asset('images/default-logo.png') }}" class="img-thumbnail rounded-4 shadow-sm" width="180" alt="Logo Instansi">
                            </div>
                            <div class="form-text text-primary mt-3 mb-0">
                                <div class="badge fw-medium bg-primary-subtle text-primary">Keterangan :</div>
                                <div>
                                    - Jenis file yang bisa diunggah: jpg, jpeg, png. <br>
                                    - Ukuran maksimal 1 MB.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol aksi --}}
                <x-form-action-buttons>profil</x-form-action-buttons>
            </form>
        </div>
    </div>

    {{-- Script preview gambar --}}
    <script>
        function previewImage(event, idPreview) {
            const input = event.target;
            const preview = document.getElementById(idPreview);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
