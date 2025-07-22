<x-app-layout> 
    <x-slot:title>Dasar Hukum</x-slot:title>
    <x-slot:breadcrumb>Ubah</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">
            {{-- Judul Form --}}
            <x-form-title>
                <i class="ti ti-edit fs-5 me-2"></i> Ubah Data Dasar Hukum
            </x-form-title>

            {{-- Form Ubah Data --}}
            <form action="{{ route('dasarhukum.update', $dasar_hukum->id_dasar_hukum) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Nama Dasar Hukum --}}
                <div class="mb-4">
                    <label class="form-label">Nama Dasar Hukum <span class="text-danger">*</span></label>
                    <input type="text" name="nama_dasar_hukum"
                        class="form-control @error('nama_dasar_hukum') is-invalid @enderror"
                        value="{{ old('nama_dasar_hukum', $dasar_hukum->nama_dasar_hukum) }}" autocomplete="off" required>
                    @error('nama_dasar_hukum')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tabel File --}}
                <div class="table-responsive mb-3">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%">No</th>
                                <th>Nama File</th>
                                <th style="width: 10%">File</th>
                                <th style="width: 35%">Ganti File</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>{{ $dasar_hukum->dokumen_dasar_hukum }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                        onclick="showPDFPreview('{{ asset('storage/dasarhukum/' . $dasar_hukum->dokumen_dasar_hukum) }}', '{{ $dasar_hukum->dokumen_dasar_hukum }}')">
                                        <i class="ti ti-eye"></i>
                                    </button>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="file" name="dokumen_dasar_hukum"
                                            class="form-control @error('dokumen_dasar_hukum') is-invalid @enderror"
                                            accept="application/pdf">
                                        <button type="submit" class="btn btn-primary btn-sm">Ganti</button>
                                    </div>
                                    @error('dokumen_dasar_hukum')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Keterangan --}}
                <div class="form-text text-primary mb-3">
                    <span class="badge bg-primary-subtle text-primary fw-medium">Keterangan :</span>
                    <div>
                        - Jenis file yang bisa diunggah adalah: PDF. <br>
                        - Ukuran file maksimal 5 MB.
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <x-form-action-buttons>jenis</x-form-action-buttons>
            </form>
        </div>
    </div>

    {{-- Modal Preview PDF --}}
    <div class="modal fade" id="pdfPreviewModal" tabindex="-1" aria-labelledby="pdfPreviewLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfPreviewLabel">Preview Dokumen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <embed id="pdfEmbed" src="" type="application/pdf" width="100%" height="600px" class="border rounded" />
                </div>
            </div>
        </div>
    </div>

    {{-- Script Preview --}}
    <script>
        function showPDFPreview(pdfUrl, fileName) {
            const embed = document.getElementById('pdfEmbed');
            embed.src = pdfUrl;

            const titleElement = document.getElementById('pdfPreviewLabel');
            if (titleElement) {
                titleElement.innerText = fileName;
            }

            const modal = new bootstrap.Modal(document.getElementById('pdfPreviewModal'));
            modal.show();
        }
    </script>
</x-app-layout>
