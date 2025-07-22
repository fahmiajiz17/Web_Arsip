<x-app-layout>
    <x-slot:title>Dasar Hukum Arsip</x-slot:title>
    <x-slot:breadcrumb>Detail</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">
            
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="ti ti-check me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            {{-- judul form --}}
            <x-form-title>
                <i class="ti ti-list fs-5 me-2"></i> Detail Dasar Hukum
            </x-form-title>

            {{-- tampilkan detail data --}}
            <div class="table-responsive border rounded mb-4">
                <table class="table align-middle text-nowrap mb-0">
                    <tr>
                        <td width="200">Nama Dasar Hukum</td>
                        <td width="10">:</td>
                        <td>{{ $dasar_hukum->nama_dasar_hukum }}</td>
                    </tr>
                </table>
            </div>
            {{-- tampilkan dokumen elektronik --}}
            <div class="pt-2">
                <iframe src="{{ asset('storage/dasarhukum/' . $dasar_hukum->dokumen_dasar_hukum) }}" width="100%"
                    height="700px" class="border rounded">
                </iframe>
            </div>

            {{-- tombol kembali --}}
            <a href="{{ route('dasarhukum.index') }}" class="btn btn-secondary mt-3">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</x-app-layout>
