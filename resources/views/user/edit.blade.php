<x-app-layout>
    <x-slot:title>User</x-slot:title>
    <x-slot:breadcrumb>Ubah</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">
            {{-- judul form --}}
            <x-form-title>
                <i class="ti ti-edit fs-5 me-2"></i> Ubah Data User
            </x-form-title>

            {{-- form ubah data --}}
            <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    {{-- Kolom Kiri --}}
                    <div class="col-lg-6">
                        {{-- Nama User --}}
                        <div class="mb-3">
                            <label class="form-label">Nama User <span class="text-danger">*</span></label>
                            <input type="text" name="nama_user" class="form-control @error('nama_user') is-invalid @enderror" value="{{ old('nama_user', $user->nama_user) }}" autocomplete="off">
                            @error('nama_user')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Username --}}
                        <div class="mb-3">
                            <label class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $user->username) }}" autocomplete="off">
                            @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Role --}}
                        <div class="mb-3">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select name="role" class="form-select select2-single @error('role') is-invalid @enderror" autocomplete="off">
                                <option disabled value="">- Pilih -</option>
                                @foreach ($role as $roleItem)
                                <option value="{{ $roleItem->id }}" {{ old('role', $user->role) == $roleItem->id ? 'selected' : '' }}>
                                    {{ $roleItem->nama }}
                                </option>
                                @endforeach
                            </select>
                            @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="col-lg-6">
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
                            @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="form-text text-muted">
                                Format:
                                <ul class="mb-0">
                                    <li>JPG, JPEG, PNG.</li>
                                    <li>Ukuran maksimum: 2MB.</li>
                                </ul>
                            </div>
                        </div>

                        {{-- Foto saat ini --}}
                        @if ($user->foto)
                        <div class="mb-3">
                            <label class="form-label d-block">Foto Saat Ini:</label>
                            <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto User" class="img-thumbnail" width="100">
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Tombol aksi --}}
                <x-form-action-buttons>user</x-form-action-buttons>
            </form>
        </div>
    </div>
</x-app-layout>