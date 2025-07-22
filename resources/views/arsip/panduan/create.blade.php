<x-app-layout>
    <x-slot:title>Panduan Arsip</x-slot:title>
    <x-slot:breadcrumb>Tambah</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">
            {{-- Judul Form --}}
            <x-form-title>
                <i class="ti ti-pencil-plus fs-5 me-2"></i> Tambah Data Panduan Arsip
            </x-form-title>

            {{-- Form Tambah Data --}}
            <form action="{{ route('panduan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nama Dokumen --}}
                <div class="form-group mb-3">
                    <label for="nama_dokumen">Nama Dokumen <span class="text-danger">*</span></label>
                    <input type="text" name="nama_dokumen" class="form-control" required>
                </div>

                {{-- Upload Dokumen PDF --}}
                <div class="form-group mb-3">
                    <label for="dokumen_panduan">Upload Dokumen (PDF)</label>
                    <input type="file" name="dokumen_panduan[]" id="dokumen_panduan"
                        class="form-control" accept="application/pdf" multiple>

                    {{-- Informasi Format File --}}
                    <div class="form-text text-primary mt-2">
                        <div class="badge fw-medium bg-primary-subtle text-primary">Keterangan :</div>
                        <div class="mt-1">
                            - Jenis file yang bisa diunggah adalah: <strong>PDF</strong>. <br>
                            - Ukuran file maksimal: <strong>5 MB</strong>.
                        </div>
                    </div>

                    {{-- Peringatan Ukuran File --}}
                    <div id="file-size-warning" class="fw-medium text-danger mt-2" style="font-size: 13px;"></div>

                    {{-- Pesan Error --}}
                    <div id="file-size-error" class="alert alert-danger d-none"
                        style="font-size: 13px; padding: 10px 14px; position: relative; border-radius: 6px;">
                        <span id="file-size-error-message"></span>
                        <button type="button" id="file-size-error-close"
                            style="position: absolute; top: 4px; right: 8px; background: none; border: none; font-size: 16px; cursor: pointer;">
                            &times;
                        </button>
                    </div>

                    {{-- Preview File yang Diunggah --}}
                    <div class="mb-4" id="uploaded-files">
                        {{-- List file akan ditampilkan di sini --}}
                    </div>

                    {{-- Hidden Input untuk Simpan Data Final (jika diperlukan untuk backend) --}}
                    <input type="hidden" name="dokumen_panduan_final" id="dokumen_panduan_final">
                </div>

                {{-- Tombol Aksi --}}
                <x-form-action-buttons>panduan arsip</x-form-action-buttons>
            </form>
        </div>
    </div>

    {{-- Script Preview dan Validasi File --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const input = document.getElementById("dokumen_panduan");
            const previewContainer = document.getElementById("uploaded-files");
            const warningContainer = document.getElementById("file-size-warning");
            const errorContainer = document.getElementById("file-size-error");
            const errorMessage = document.getElementById("file-size-error-message");
            const errorCloseBtn = document.getElementById("file-size-error-close");
            const form = document.querySelector("form");

            let selectedFiles = [];

            input.addEventListener("change", function () {
                const newFiles = Array.from(this.files);
                const combinedFiles = [...selectedFiles, ...newFiles];
                const totalSize = combinedFiles.reduce((acc, file) => acc + file.size, 0);

                if (totalSize > 5 * 1024 * 1024) {
                    showError("Total ukuran file melebihi batas maksimum 5 MB! Silakan kurangi file yang diunggah.");
                } else {
                    hideError();
                }

                selectedFiles = combinedFiles;
                updateFileInput();
                showPreview();
            });

            form.addEventListener("submit", function (e) {
                const totalSize = selectedFiles.reduce((acc, file) => acc + file.size, 0);
                if (totalSize > 5 * 1024 * 1024) {
                    e.preventDefault();
                    showError("Total ukuran file masih melebihi batas maksimum 5 MB! Form tidak dapat dikirim.");
                }
            });

            function showPreview() {
                previewContainer.innerHTML = "";
                let totalSize = 0;

                selectedFiles.forEach((file, index) => {
                    const sizeInKB = (file.size / 1024).toFixed(2);
                    totalSize += file.size;

                    const itemWrapper = document.createElement("div");
                    itemWrapper.className = "d-flex justify-content-between align-items-center border rounded px-3 py-2 mb-2";
                    itemWrapper.style.backgroundColor = "#f9f9f9";

                    const leftPart = document.createElement("div");
                    leftPart.innerHTML = `
                        <i class="ti ti-file-filled me-2 text-danger"></i>
                        ${file.name}<br>
                        <small class="text-muted">${sizeInKB} KB</small>
                    `;

                    const rightPart = document.createElement("button");
                    rightPart.className = "btn btn-sm btn-danger";
                    rightPart.textContent = "×";
                    rightPart.setAttribute("data-index", index);

                    itemWrapper.appendChild(leftPart);
                    itemWrapper.appendChild(rightPart);
                    previewContainer.appendChild(itemWrapper);
                });

                const totalSizeMB = (totalSize / (1024 * 1024)).toFixed(2);
                warningContainer.innerHTML = `<strong class="text-danger">Ukuran Dokumen: ${totalSizeMB} MB</strong>`;

                document.querySelectorAll('button[data-index]').forEach(button => {
                    button.addEventListener("click", function () {
                        const index = parseInt(this.getAttribute("data-index"));
                        selectedFiles.splice(index, 1);
                        updateFileInput();
                        showPreview();

                        const updatedTotalSize = selectedFiles.reduce((acc, file) => acc + file.size, 0);
                        if (updatedTotalSize <= 5 * 1024 * 1024) {
                            hideError();
                        }
                    });
                });
            }

            function updateFileInput() {
                const dataTransfer = new DataTransfer();
                selectedFiles.forEach(file => dataTransfer.items.add(file));
                input.files = dataTransfer.files;
            }

            function showError(message) {
                errorMessage.textContent = message;
                errorContainer.classList.remove("d-none");
            }

            function hideError() {
                errorContainer.classList.add("d-none");
                errorMessage.textContent = '';
            }

            errorCloseBtn.addEventListener("click", hideError);
        });
    </script>
</x-app-layout>
