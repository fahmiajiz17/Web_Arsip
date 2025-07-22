<x-app-layout>
    <x-slot:title>Panduan Penggunaan</x-slot:title>
    <x-slot:breadcrumb>Detail</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">
            {{-- Judul Form --}}
            <x-form-title>
                <i class="ti ti-list fs-5 me-2"></i> Detail Panduan Penggunaan
            </x-form-title>

            {{-- Tampilkan Detail Data --}}
            <div class="table-responsive border rounded mb-4">
                <table class="table align-middle text-nowrap mb-0">
                    <tr>
                        <td width="200">Nama Dokumen</td>
                        <td width="10">:</td>
                        <td>{{ $panduan->nama_dokumen }}</td>
                    </tr>
                </table>
            </div>

            {{-- Tampilkan Daftar Dokumen --}}
            @php
                $files = is_string($panduan->dokumen_panduan)
                    ? json_decode($panduan->dokumen_panduan, true)
                    : $panduan->dokumen_panduan;
            @endphp

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" width="50">No</th>
                            <th>Nama File</th>
                            <th class="text-center" width="120">Preview</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($files as $index => $file)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $file }}</td>
                                <td class="text-center">
                                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalPreview{{ $index }}">
                                        <i class="ti ti-eye"></i>
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="modalPreview{{ $index }}" tabindex="-1" aria-labelledby="modalLabel{{ $index }}" aria-hidden="true">
                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalLabel{{ $index }}">
                                                        Preview Dokumen: {{ $file }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" style="height: 80vh;">
                                                    <iframe src="{{ asset('storage/panduan/' . $file) }}"
                                                            width="100%" height="100%" class="border rounded"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal -->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Tombol Kembali --}}
            <a href="{{ route('panduan.index') }}" class="btn btn-secondary mt-3">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</x-app-layout>
