<x-app-layout>
    <x-slot:title>User</x-slot:title>
    <x-slot:breadcrumb>Tambah</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">
            {{-- judul form --}}
            <x-form-title>
                <i class="ti ti-pencil-plus fs-5 me-2"></i> Tambah Data User
            </x-form-title>

            {{-- form tambah data --}}
            <form action="{{ route('user.store.data') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    {{-- Kolom Kiri --}}
                    <div class="col-lg-6">
                        {{-- Nama User --}}
                        <div class="mb-3">
                            <label class="form-label">Nama User <span class="text-danger">*</span></label>
                            <input type="text" name="nama_user" class="form-control @error('nama_user') is-invalid @enderror" value="{{ old('nama_user') }}" autocomplete="off">
                            @error('nama_user')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Username --}}
                        <div class="mb-3">
                            <label class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" autocomplete="off">
                            @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="form-text text-muted">
                                Yang akan digunakan untuk login ke dalam sistem.
                            </div>

                        </div>

                        {{-- Role --}}
                        <div class="mb-3">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select name="role" class="form-select select2-single @error('role') is-invalid @enderror" autocomplete="off" required>
                                <option selected disabled value="">- Pilih -</option>
                                @foreach ($role as $r)
                                <option value="{{ $r->id }}" {{ old('role') == $r->id ? 'selected' : '' }}>
                                    {{ $r->nama }}
                                </option>
                                @endforeach
                            </select>
                            @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            {{-- Informasi format dan ukuran --}}
                            <div class="form-text text-muted">
                                Jika role belum ada, daftarkan di menu Manajemen Role.
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="col-lg-6">
                        {{-- Password --}}
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control toggle-password"
                                    autocomplete="new-password">
                                <span class="input-group-text bg-white toggle-password-btn" style="cursor: pointer;">
                                    <i class="ti ti-eye"></i>
                                </span>
                            </div>
                            @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Foto --}}
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept=".jpg,.jpeg,.png">

                            {{-- Pesan error --}}
                            @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            {{-- Informasi format dan ukuran --}}
                            <div class="form-text text-muted">
                                Format:
                                <ul class="mb-0">
                                    <li>JPG, JPEG, PNG.</li>
                                    <li>Ukuran maksimum: 2MB.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <x-form-action-buttons>user</x-form-action-buttons>
            </form>
        </div>
    </div>
</x-app-layout>