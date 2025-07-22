<x-app-layout>
    <x-slot:title>Role</x-slot:title>
    <x-slot:breadcrumb>Tambah</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">
            {{-- judul form --}}
            <x-form-title>
                <i class="ti ti-pencil-plus fs-5 me-2"></i> Tambah Role
            </x-form-title>

            {{-- form tambah data --}}
            <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Role <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" autocomplete="off">

                            {{-- pesan error untuk nama user --}}
                            @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- action buttons --}}
                <x-form-action-buttons>user</x-form-action-buttons>
            </form>
        </div>
    </div>
</x-app-layout>