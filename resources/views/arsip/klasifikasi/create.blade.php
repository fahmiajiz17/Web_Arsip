<x-app-layout>
    <x-slot:title>Klasifikasi Arsip</x-slot:title>
    <x-slot:breadcrumb>Tambah</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">
            {{-- Judul Form --}}
            <x-form-title>
                <i class="ti ti-pencil-plus fs-5 me-2"></i> Tambah Data Klasifikasi Arsip
            </x-form-title>

            {{-- Form Tambah Data --}}
            <form action="{{ route('klasifikasi.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        @foreach([
                            ['label' => 'Kode Klasifikasi', 'name' => 'kode_klasifikasi', 'type' => 'text'],
                            ['label' => 'Jenis Dokumen', 'name' => 'jenis_dokumen', 'type' => 'text'],
                            ['label' => 'Klasifikasi Keamanan', 'name' => 'klasifikasi_keamanan', 'type' => 'text'],
                            ['label' => 'Hak Akses', 'name' => 'hak_akses', 'type' => 'text'],
                            ['label' => 'Akses Publik', 'name' => 'akses_publik', 'type' => 'text'],
                            ['label' => 'Retensi Aktif', 'name' => 'retensi_aktif', 'type' => 'number'],
                            ['label' => 'Retensi Inaktif', 'name' => 'retensi_inaktif', 'type' => 'number'],
                            ['label' => 'Retensi Keterangan', 'name' => 'retensi_keterangan', 'type' => 'text'],
                            ['label' => 'Unit Pengolah', 'name' => 'unit_pengolah', 'type' => 'text'],
                        ] as $field)
                            <div class="mb-3">
                                <label class="form-label">
                                    {{ $field['label'] }} <span class="text-danger">*</span>
                                </label>
                                <input type="{{ $field['type'] }}" name="{{ $field['name'] }}"
                                    class="form-control @error($field['name']) is-invalid @enderror"
                                    value="{{ old($field['name']) }}" autocomplete="off">
                                @error($field['name'])
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <x-form-action-buttons>klasifikasi</x-form-action-buttons>
            </form>
        </div>
    </div>
</x-app-layout>
