<x-app-layout>
    <x-slot:title>Arsip Dokumen</x-slot:title>
    <x-slot:breadcrumb>Tambah</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">
            <x-form-title>
                <i class="ti ti-pencil-plus fs-5 me-2"></i> Tambah Data Arsip Dokumen
            </x-form-title>

            <form action="{{ route('arsip.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        {{-- Nama Dokumen --}}
                        <div class="mb-3">
                            <label class="form-label">Nama Dokumen <span class="text-danger">*</span></label>
                            <input type="text" name="nama_dokumen"
                                class="form-control @error('nama_dokumen') is-invalid @enderror"
                                value="{{ old('nama_dokumen') }}" placeholder="Masukkan Nama Dokumen" required>
                            @error('nama_dokumen')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal Arsip --}}
                        <div class="mb-3">
                            <label class="form-label">Tanggal Arsip <span class="text-danger">*</span></label>
                            <input type="text" name="tanggal_arsip"
                                class="form-control datepicker @error('tanggal_arsip') is-invalid @enderror"
                                value="{{ old('tanggal_arsip') }}" placeholder="Pilih Tanggal" required>
                            @error('tanggal_arsip')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Deskripsi Arsip --}}
                        <div class="mb-3">
                            <label class="form-label">Deskripsi Arsip</label>
                            <textarea name="deskripsi_arsip" class="form-control @error('deskripsi_arsip') is-invalid @enderror"
                                placeholder="Masukkan deskripsi arsip" rows="4">{{ old('deskripsi_arsip') }}</textarea>
                            @error('deskripsi_arsip')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Dasar Hukum --}}
                        <div class="mb-3">
                            <label class="form-label">Dasar Hukum <span class="text-danger">*</span></label>
                            <select name="dasar_hukum"
                                class="form-select select2-single @error('dasar_hukum') is-invalid @enderror" required>
                                <option value="">- Pilih Dasar Hukum -</option>
                                @foreach ($dasar_hukum as $data)
                                <option value="{{ $data->id_dasar_hukum }}"
                                    {{ old('dasar_hukum') == $data->id_dasar_hukum ? 'selected' : '' }}>
                                    {{ $data->nama_dasar_hukum }}
                                </option>
                                @endforeach
                            </select>
                            @error('dasar_hukum')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Klasifikasi --}}
                        <div class="mb-3">
                            <label class="form-label">Klasifikasi <span class="text-danger">*</span></label>
                            <select id="id_klasifikasi" name="klasifikasi"
                                class="form-select select2-single @error('klasifikasi') is-invalid @enderror" required>
                                <option selected value="">- Pilih Klasifikasi -</option>
                                @foreach ($klasifikasi as $data)
                                <option value="{{ $data->id_klasifikasi }}"
                                    {{ old('klasifikasi') == $data->id_klasifikasi ? 'selected' : '' }}>
                                    {{ $data->kode_klasifikasi }} - {{ $data->jenis_dokumen }}
                                </option>
                                @endforeach
                            </select>
                            @error('klasifikasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Retensi Aktif --}}
                        <div class="mb-3">
                            <label class="form-label">Retensi Aktif</label>
                            <input type="text" id="retensi_aktif" name="jadwal_retensi_arsip_aktif"
                                class="form-control" placeholder="Terisi otomatis ketika memilih klasifikasi (tahun)"
                                readonly>
                        </div>

                        {{-- Retensi Inaktif --}}
                        <div class="mb-3">
                            <label class="form-label">Retensi Inaktif</label>
                            <input type="text" id="retensi_inaktif" name="jadwal_retensi_arsip_inaktif"
                                class="form-control" placeholder="Terisi otomatis ketika memilih klasifikasi (tahun)"
                                readonly>
                        </div>

                        {{-- Penyusutan --}}
                        <div class="mb-3">
                            <label class="form-label">Penyusutan Akhir</label>
                            <input type="text" name="penyusutan_akhir"
                                class="form-control @error('penyusutan_akhir') is-invalid @enderror"
                                value="{{ old('penyusutan_akhir') }}" placeholder="Masukkan penyusutan akhir">
                            @error('penyusutan_akhir')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Keamanan Arsip --}}
                        <div class="mb-3">
                            <label class="form-label">Keamanan Arsip</label>
                            <input type="text" name="keamanan_arsip" id="klasifikasi_keamanan" class="form-control"
                                placeholder="Terisi otomatis ketika memilih klasifikasi" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status Dokumen <span class="text-danger">*</span></label>
                            <select name="status_dokumen"
                                class="form-select select2-single @error('status_dokumen') is-invalid @enderror"
                                required>
                                <option value="">- Pilih Status -</option>
                                <option value="Aktif" {{ old('status_dokumen') == 'Aktif' ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="Inaktif" {{ old('status_dokumen') == 'Inaktif' ? 'selected' : '' }}>
                                    Inaktif</option>
                                <option value="Musnah" {{ old('status_dokumen') == 'Musnah' ? 'selected' : '' }}>Musnah
                                </option>
                            </select>
                            @error('status_dokumen')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6">
                        {{-- Keterangan Penyusutan --}}
                        <div class="mb-3">
                            <label class="form-label">Keterangan Penyusutan</label>
                            <input type="text" name="keterangan_penyusutan" id="retensi_keterangan"
                                class="form-control" placeholder="Terisi otomatis ketika memilih klasifikasi" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lokasi Penyimpanan <span class="text-danger">*</span></label>
                            <input type="text" name="lokasi_penyimpanan"
                                class="form-control @error('lokasi_penyimpanan') is-invalid @enderror"
                                value="{{ old('lokasi_penyimpanan') }}" placeholder="Masukkan lokasi penyimpanan"
                                required>
                            @error('lokasi_penyimpanan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Filling Cabinet</label>
                            <input type="text" name="filling_cabinet"
                                class="form-control @error('filling_cabinet') is-invalid @enderror"
                                value="{{ old('filling_cabinet') }}" placeholder="Masukkan filling cabinet">
                            @error('filling_cabinet')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Laci</label>
                            <input type="text" name="laci"
                                class="form-control @error('laci') is-invalid @enderror" value="{{ old('laci') }}"
                                placeholder="Masukkan laci">
                            @error('laci')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Folder</label>
                            <input type="text" name="folder"
                                class="form-control @error('folder') is-invalid @enderror"
                                value="{{ old('folder') }}" placeholder="Masukkan folder">
                            @error('folder')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kata_kunci_input">Kata Kunci</label>
                            <div class="form-control d-flex flex-wrap align-items-center" id="kata_kunci_wrapper"
                                style="min-height: 40px;">
                                <div id="kata_kunci_container" class="d-flex flex-wrap me-2 mb-1"></div>
                                <input type="text" id="kata_kunci_input" class="border-0 flex-grow-1"
                                    placeholder="Ketik kata kunci lalu tekan Enter">
                            </div>
                            <input type="hidden" name="kata_kunci" id="kata_kunci_hidden">
                        </div>

                        <!-- Batas Retensi Aktif (hidden) -->
                        <div class="mb-3">
                            <input type="hidden" name="batas_status_retensi_aktif" id="batas_status_retensi_aktif"
                                class="form-control" value="{{ old('batas_status_retensi_aktif') }}">
                        </div>

                        <!-- Batas Retensi Inaktif (hidden) -->
                        <div class="mb-3">
                            <input type="hidden" name="batas_status_retensi_inaktif"
                                id="batas_status_retensi_inaktif" class="form-control">
                        </div>


                        {{-- Pilihan Ya/Tidak --}}
                        @php
                        $booleanOptions = ['Ya' => 'Ya', 'Tidak' => 'Tidak'];
                        @endphp

                        @foreach (['vital', 'terjaga', 'memori_kolektif_bangsa'] as $field)
                        <div class="mb-3">
                            <label class="form-label">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                            <select name="{{ $field }}"
                                class="form-select @error($field) is-invalid @enderror">
                                <option value="">- Pilih -</option>
                                @foreach ($booleanOptions as $val => $label)
                                <option value="{{ $val }}"
                                    {{ old($field) == $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error($field)
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @endforeach
                    </div>
                    {{-- Dokumen Elektronik --}}
                    <div class="form-group mb-3">
                        <label for="arsip_dokumen">Upload Dokumen (PDF)</label>
                        <input type="file" name="arsip_dokumen[]" id="arsip_dokumen" class="form-control"
                            accept="application/pdf" multiple>
                        <div class="form-text text-primary mb-3">
                            <div class="badge fw-medium bg-primary-subtle text-primary">Keterangan :</div>
                            <div>
                                - Jenis file yang bisa diunggah adalah: pdf. <br>
                                - Ukuran file yang bisa diunggah maksimal 5 MB.
                            </div>
                        </div>
                        {{-- Total ukuran file --}}
                        <div id="total-size-info" class="fw-medium text-danger mb-2" style="font-size: 13px;"></div>
                        <input type="hidden" name="total_file_size" id="total_file_size">
                    </div>
                    <div id="alert-max-size"
                        class="alert alert-danger d-flex justify-content-between align-items-center d-none"
                        role="alert" style="background-color: #ffd5cc; color: #e63946;">
                        <div>
                            Total ukuran file melebihi batas maksimum 5 MB! Silakan kurangi file yang diunggah.
                        </div>
                        <button type="button" class="btn-close" aria-label="Close" onclick="closeAlert()"
                            style="font-size: 20px; background: none; border: none; color: #e63946;">&times;</button>
                    </div>

                    <input type="hidden" name="total_file_size" id="total_file_size">
                </div>

                <div class="row gap-2 mb-4" id="uploaded-files"></div>
                <input type="hidden" name="arsip_dokumen_final" id="arsip_dokumen_final">
                <x-form-action-buttons>klasifikasi</x-form-action-buttons>


                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        /** ========== BAGIAN 1: File Upload dengan Preview + Size Validation ========== */
                        const input = document.getElementById("arsip_dokumen");
                        const previewContainer = document.getElementById("uploaded-files");
                        const totalSizeDisplay = document.getElementById("total-size-info");
                        const totalSizeHidden = document.getElementById("total_file_size");

                        const maxTotalSize = 5 * 1024 * 1024; // 5 MB
                        let selectedFiles = [];

                        input.addEventListener("change", function() {
                            const newFiles = Array.from(this.files);
                            const combinedFiles = [...selectedFiles, ...newFiles];
                            const totalSize = combinedFiles.reduce((acc, file) => acc + file.size, 0);

                            // Allow files to be added regardless of total size
                            selectedFiles = combinedFiles;
                            updateFileInput();
                            showPreview();
                        });

                        function showPreview() {
                            previewContainer.innerHTML = "";
                            let totalSize = 0;

                            selectedFiles.forEach((file, index) => {
                                totalSize += file.size;
                                const sizeInKB = (file.size / 1024).toFixed(2);

                                const filePreview = document.createElement("div");
                                filePreview.classList.add("d-flex", "align-items-center", "justify-content-between",
                                    "mb-2", "p-2");
                                filePreview.style.border = "1px solid #ccc";
                                filePreview.style.borderRadius = "6px";
                                filePreview.style.backgroundColor = "#f9f9f9";

                                filePreview.innerHTML =
                                    `
                <div class="d-flex align-items-center gap-2">
                    <img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" alt="PDF" style="width:24px;">
                    <div>
                        <div class="fw-medium text-dark" style="font-size: 14px;">${file.name}</div>
                        <div class="text-muted" style="font-size: 12px;">${sizeInKB} KB</div>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-danger px-2 py-0" data-index="${index}" style="font-size:14px;">&times;</button>`;

                                previewContainer.appendChild(filePreview);
                            });

                            totalSizeDisplay.innerHTML =
                                `<strong>Total ukuran file: ${formatBytes(totalSize)} (maksimal 5 MB)</strong>`;

                            totalSizeHidden.value = totalSize;

                            // Tampilkan atau sembunyikan alert jika melebihi batas
                            const alertBox = document.getElementById("alert-max-size");
                            if (totalSize > maxTotalSize) {
                                alertBox.classList.remove("d-none");
                            } else {
                                alertBox.classList.add("d-none");
                            }

                            // Tombol hapus
                            document.querySelectorAll('button[data-index]').forEach(button => {
                                button.addEventListener("click", function() {
                                    const index = parseInt(this.getAttribute("data-index"));
                                    selectedFiles.splice(index, 1);
                                    updateFileInput();
                                    showPreview();
                                });
                            });
                        }

                        function updateFileInput() {
                            const dataTransfer = new DataTransfer();
                            selectedFiles.forEach(file => dataTransfer.items.add(file));
                            input.files = dataTransfer.files;
                        }

                        function formatBytes(bytes) {
                            if (bytes === 0) return '0 Bytes';
                            const k = 1024;
                            const sizes = ['Bytes', 'KB', 'MB'];
                            const i = Math.floor(Math.log(bytes) / Math.log(k));
                            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
                        }

                        /** ========== BAGIAN 2: Auto-Fill Data Retensi dari AJAX ========== */
                        $('#id_klasifikasi').on('change', function() {
                            var id = $(this).val();
                            if (id) {
                                $.ajax({
                                    url: '/get-klasifikasi/' + id,
                                    type: 'GET',
                                    success: function(data) {
                                        $('#retensi_aktif').val(data.retensi_aktif);
                                        $('#retensi_inaktif').val(data.retensi_inaktif);
                                        $('#retensi_keterangan').val(data.retensi_keterangan);
                                        $('#klasifikasi_keamanan').val(data.klasifikasi_keamanan);
                                        hitungBatasRetensi();
                                    }
                                });
                            }
                        });

                        /** ========== BAGIAN 3: Perhitungan Batas Retensi Aktif & Inaktif ========== */
                        function formatTanggalUntukDB(date) {
                            var d = ('0' + date.getDate()).slice(-2);
                            var m = ('0' + (date.getMonth() + 1)).slice(-2);
                            var y = date.getFullYear();
                            return `${y}-${m}-${d}`;
                        }

                        function hitungBatasRetensi() {
                            var tanggalArsip = $('input[name="tanggal_arsip"]').val();
                            var retensiAktif = parseInt($('#retensi_aktif').val());
                            var retensiInaktif = parseInt($('#retensi_inaktif').val());

                            if (tanggalArsip && !isNaN(retensiAktif) && !isNaN(retensiInaktif)) {
                                var parts = tanggalArsip.split('-');
                                var tanggalAwal = new Date(parts[0], 11, 31); // 31 Desember tahun arsip

                                var tanggalRetensiAktif = new Date(tanggalAwal);
                                tanggalRetensiAktif.setFullYear(tanggalRetensiAktif.getFullYear() + retensiAktif);
                                $('#batas_status_retensi_aktif').val(formatTanggalUntukDB(tanggalRetensiAktif));

                                var tanggalRetensiInaktif = new Date(tanggalAwal);
                                tanggalRetensiInaktif.setFullYear(tanggalRetensiInaktif.getFullYear() + retensiInaktif);
                                $('#batas_status_retensi_inaktif').val(formatTanggalUntukDB(tanggalRetensiInaktif));
                            } else {
                                $('#batas_status_retensi_aktif').val('');
                                $('#batas_status_retensi_inaktif').val('');
                            }
                        }

                        $('input[name="tanggal_arsip"]').on('change', hitungBatasRetensi);
                        $('#retensi_aktif, #retensi_inaktif').on('change', hitungBatasRetensi);

                        /** ========== BAGIAN 4: Tag Input Kata Kunci ========== */
                        const kataKunciInput = document.getElementById('kata_kunci_input');
                        const kataKunciContainer = document.getElementById('kata_kunci_container');
                        const kataKunciHidden = document.getElementById('kata_kunci_hidden');

                        // Fungsi render tags
                        function renderTags(tags) {
                            kataKunciContainer.innerHTML = '';
                            tags.forEach(tag => {
                                const tagElem = document.createElement('span');
                                tagElem.className = 'badge bg-primary me-1 mb-1';
                                tagElem.textContent = tag;

                                const removeBtn = document.createElement('button');
                                removeBtn.type = 'button';
                                removeBtn.className = 'btn-close btn-close-white btn-sm ms-2';
                                removeBtn.setAttribute('aria-label', 'Close');

                                // Saat tombol X diklik, hapus tag
                                removeBtn.onclick = () => {
                                    tags = tags.filter(t => t !== tag);
                                    updateTags(tags);
                                };

                                tagElem.appendChild(removeBtn);
                                kataKunciContainer.appendChild(tagElem);
                            });

                            // Simpan ke hidden input sebagai JSON string
                            kataKunciHidden.value = JSON.stringify(tags);
                        }

                        // Fungsi update tags
                        function updateTags(tags) {
                            renderTags(tags);
                        }

                        // Inisialisasi tags dari hidden input
                        let tags = [];
                        try {
                            tags = JSON.parse(kataKunciHidden.value);
                            if (!Array.isArray(tags)) tags = [];
                        } catch (e) {
                            tags = [];
                        }

                        renderTags(tags);

                        // Saat tekan Enter pada input
                        kataKunciInput.addEventListener('keydown', function(e) {
                            if (e.key === 'Enter') {
                                e.preventDefault();
                                let tag = kataKunciInput.value.trim();

                                // Hindari tag kosong atau duplikat (case-insensitive)
                                if (tag && !tags.map(t => t.toLowerCase()).includes(tag.toLowerCase())) {
                                    tags.push(tag);
                                    updateTags(tags);
                                }

                                kataKunciInput.value = '';
                            }
                        });

                        /** ========== BAGIAN 5: Cegah Submit Jika Ukuran File > 5 MB ========== */
                        const form = document.querySelector("form");
                        form.addEventListener("submit", function(e) {
                            const totalSize = selectedFiles.reduce((acc, file) => acc + file.size, 0);
                            if (totalSize > maxTotalSize) {
                                e.preventDefault(); // Cegah pengiriman form

                                const alertBox = document.getElementById("alert-max-size");
                                alertBox.classList.remove("d-none");
                                alertBox.querySelector("div").textContent =
                                    "Total ukuran file masih melebihi 5 MB! Harap kurangi dokumen yang diunggah.";
                            }
                        });
                    });

                    /** Fungsi untuk menutup alert max size */
                    function closeAlert() {
                        document.getElementById("alert-max-size").classList.add("d-none");
                    }
                </script>

</x-app-layout>