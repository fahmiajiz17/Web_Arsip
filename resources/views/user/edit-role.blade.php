<x-app-layout>
    <x-slot:title>Role</x-slot:title>
    <x-slot:breadcrumb>Ubah Role</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">
            {{-- Judul form --}}
            <x-form-title>
                <i class="ti ti-edit fs-5 me-2"></i> Ubah Data Role
            </x-form-title>

            {{-- Form ubah data --}}
            <form action="{{ route('user.update-role', $role->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Role <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="nama"
                                name="nama"
                                class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $role->nama) }}"
                                autocomplete="off">

                            {{-- Pesan error untuk nama --}}
                            @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Tombol aksi (simpan & kembali) --}}
                <x-form-action-buttons route="role.role" />
            </form>
        </div>
    </div>
</x-app-layout>