<x-app-layout>
    <x-slot:title>Edit Arsip Dokumen</x-slot:title>
    <x-slot:breadcrumb>Edit</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">
            <x-form-title>
                <i class="ti ti-pencil fs-5 me-2"></i> Edit Data Arsip Dokumen
            </x-form-title>

            <form action="{{ route('arsip.update', $arsip->nomor_dokumen) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-lg-6">
                        {{-- Kode Dokumen (readonly) --}}
                        <div class="mb-3">
                            <label class="form-label">Kode Dokumen</label>
                            <input type="text" name="kode_dokumen" class="form-control" id="kode_dokumen" value="{{ old('kode_dokumen', $arsip->kode_dokumen) }}" readonly>
                        </div>

                        {{-- Nama Dokumen --}}
                        <div class="mb-3">
                            <label class="form-label">Nama Dokumen <span class="text-danger">*</span></label>
                            <input type="text" name="nama_dokumen"
                                class="form-control @error('nama_dokumen') is-invalid @enderror"
                                value="{{ old('nama_dokumen', $arsip->nama_dokumen) }}" placeholder="Masukkan Nama Dokumen" required>
                            @error('nama_dokumen')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal Arsip --}}
                        <div class="mb-3">
                            <label class="form-label">Tanggal Arsip <span class="text-danger">*</span></label>
                            <input type="text" name="tanggal_arsip"
                                class="form-control datepicker @error('tanggal_arsip') is-invalid @enderror"
                                value="{{ old('tanggal_arsip', $arsip->tanggal_arsip) }}" placeholder="Pilih Tanggal" required>
                            @error('tanggal_arsip')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Deskripsi Arsip --}}
                        <div class="mb-3">
                            <label class="form-label">Deskripsi Arsip</label>
                            <textarea name="deskripsi_arsip" class="form-control @error('deskripsi_arsip') is-invalid @enderror"
                                placeholder="Masukkan deskripsi arsip" rows="4">{{ old('deskripsi_arsip', $arsip->deskripsi_arsip) }}</textarea>
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
                                    {{ old('dasar_hukum', $arsip->dasar_hukum) == $data->id_dasar_hukum ? 'selected' : '' }}>
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
                                <option value="">- Pilih Klasifikasi -</option>
                                @foreach ($klasifikasi as $data)
                                <option value="{{ $data->id_klasifikasi }}"
                                    {{ old('klasifikasi', $arsip->klasifikasi) == $data->id_klasifikasi ? 'selected' : '' }}>
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
                                value="{{ old('jadwal_retensi_arsip_aktif', $arsip->jadwal_retensi_arsip_aktif) }}" readonly>
                        </div>
                        {{-- Retensi Inaktif --}}
                        <div class="mb-3">
                            <label class="form-label">Retensi Inaktif</label>
                            <input type="text" id="retensi_inaktif" name="jadwal_retensi_arsip_inaktif"
                                class="form-control" placeholder="Terisi otomatis ketika memilih klasifikasi (tahun)"
                                value="{{ old('jadwal_retensi_arsip_inaktif', $arsip->jadwal_retensi_arsip_inaktif) }}" readonly>
                        </div>

                        {{-- Keamanan Arsip --}}
                        <div class="mb-3">
                            <label class="form-label">Keamanan Arsip</label>
                            <input type="text" name="keamanan_arsip" id="klasifikasi_keamanan" class="form-control"
                                placeholder="Terisi otomatis ketika memilih klasifikasi"
                                value="{{ old('keamanan_arsip', $arsip->keamanan_arsip) }}" readonly>
                        </div>

                        {{-- Penyusutan Akhir --}}
                        <div class="mb-3">
                            <label class="form-label">Penyusutan Akhir</label>
                            <input type="text" name="penyusutan_akhir"
                                class="form-control @error('penyusutan_akhir') is-invalid @enderror"
                                value="{{ old('penyusutan_akhir', $arsip->penyusutan_akhir) }}" placeholder="Masukkan penyusutan akhir">
                            @error('penyusutan_akhir')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6">
                        {{-- Status Dokumen --}}
                        <div class="mb-3">
                            <label class="form-label">Status Dokumen <span class="text-danger">*</span></label>
                            <select name="status_dokumen"
                                class="form-select select2-single @error('status_dokumen') is-invalid @enderror" required>
                                <option value="">- Pilih Status -</option>
                                <option value="Aktif" {{ old('status_dokumen', $arsip->status_dokumen) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Inaktif" {{ old('status_dokumen', $arsip->status_dokumen) == 'Inaktif' ? 'selected' : '' }}>Inaktif</option>
                                <option value="Musnah" {{ old('status_dokumen', $arsip->status_dokumen) == 'Musnah' ? 'selected' : '' }}>Musnah</option>
                            </select>
                            @error('status_dokumen')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Keterangan Penyusutan --}}
                        <div class="mb-3">
                            <label class="form-label">Keterangan Penyusutan</label>
                            <input type="text" name="keterangan_penyusutan" id="retensi_keterangan"
                                class="form-control" placeholder="Terisi otomatis ketika memilih klasifikasi"
                                value="{{ old('keterangan_penyusutan', $arsip->keterangan_penyusutan) }}" readonly>
                        </div>

                        {{-- Lokasi Penyimpanan --}}
                        <div class="mb-3">
                            <label class="form-label">Lokasi Penyimpanan <span class="text-danger">*</span></label>
                            <input type="text" name="lokasi_penyimpanan"
                                class="form-control @error('lokasi_penyimpanan') is-invalid @enderror"
                                value="{{ old('lokasi_penyimpanan', $arsip->lokasi_penyimpanan) }}" placeholder="Masukkan lokasi penyimpanan" required>
                            @error('lokasi_penyimpanan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Filling Cabinet --}}
                        <div class="mb-3">
                            <label class="form-label">Filling Cabinet</label>
                            <input type="text" name="filling_cabinet"
                                class="form-control @error('filling_cabinet') is-invalid @enderror"
                                value="{{ old('filling_cabinet', $arsip->filling_cabinet) }}" placeholder="Masukkan filling cabinet">
                            @error('filling_cabinet')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Laci --}}
                        <div class="mb-3">
                            <label class="form-label">Laci</label>
                            <input type="text" name="laci"
                                class="form-control @error('laci') is-invalid @enderror"
                                value="{{ old('laci', $arsip->laci) }}" placeholder="Masukkan laci">
                            @error('laci')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Folder --}}
                        <div class="mb-3">
                            <label class="form-label">Folder</label>
                            <input type="text" name="folder"
                                class="form-control @error('folder') is-invalid @enderror"
                                value="{{ old('folder', $arsip->folder) }}" placeholder="Masukkan folder">
                            @error('folder')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kata Kunci --}}
                        <div class="mb-3">
                            <label for="kata_kunci_input">Kata Kunci</label>
                            <div class="form-control d-flex flex-wrap align-items-center" id="kata_kunci_wrapper" style="min-height: 40px;">
                                <div id="kata_kunci_container" class="d-flex flex-wrap me-2 mb-1"></div>
                                <input type="text" id="kata_kunci_input" class="border-0 flex-grow-1" placeholder="Ketik kata kunci lalu tekan Enter">
                            </div>
                            <input type="hidden" name="kata_kunci" id="kata_kunci_hidden" value="{{ old('kata_kunci', $arsip->kata_kunci) }}">
                        </div>

                        {{-- Hidden inputs untuk batas retensi --}}
                        <input type="hidden" name="batas_status_retensi_aktif" id="batas_status_retensi_aktif" value="{{ old('batas_status_retensi_aktif', $arsip->batas_status_retensi_aktif) }}">
                        <input type="hidden" name="batas_status_retensi_inaktif" id="batas_status_retensi_inaktif" value="{{ old('batas_status_retensi_inaktif', $arsip->batas_status_retensi_inaktif) }}">

                        @php
                        $booleanOptions = ['ya' => 'Ya', 'tidak' => 'Tidak'];
                        @endphp

                        @foreach (['vital', 'terjaga', 'memori_kolektif_bangsa'] as $field)
                        <div class="mb-3">
                            <label class="form-label">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                            <select name="{{ $field }}" class="form-select @error($field) is-invalid @enderror">
                                <option value="">- Pilih -</option>
                                @foreach ($booleanOptions as $val => $label)
                                <option value="{{ $val }}" {{ old($field, $arsip->$field) == $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error($field)
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('arsip.index') }}" class="btn btn-primary">
                        <i class="ti ti-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-secondary">
                        <i class="ti ti-device-floppy me-1"></i> Simpan
                    </button>
                </div>

            </form>

            {{-- Ambil & Decode Dokumen --}}
            @php
            $files = is_string($arsip->arsip_dokumen) ? json_decode($arsip->arsip_dokumen, true) : ($arsip->arsip_dokumen ?? []);
            @endphp
            @if (!empty($files))
            {{-- Tabel Dokumen --}}
            <div class="table-responsive mt-5 border rounded">
                <table class="table table-bordered w-100">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 50px;">No</th>
                            <th>Nama File</th>
                            <th class="text-center" style="width: 80px;">Preview</th>
                            <th style="width: 300px;">Ganti File</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($files as $index => $file)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $file }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#previewModal{{ $index }}">
                                    <i class="ti ti-eye"></i>
                                </button>
                                {{-- Modal --}}
                                <div class="modal fade" id="previewModal{{ $index }}" tabindex="-1" aria-labelledby="previewLabel{{ $index }}" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Preview: {{ $file }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body" style="height: 80vh;">
                                                <iframe src="{{ asset('storage/arsip/' . $file) }}" width="100%" height="100%" class="border rounded"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <form action="{{ route('arsip.replaceFile', ['id' => $arsip->nomor_dokumen, 'index' => $index]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="file" name="file" class="form-control form-control-sm" required accept="application/pdf">
                                        <button type="submit" class="btn btn-sm btn-primary">Ganti</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>


    <script>
        const klasifikasiInput = document.querySelector('[name="klasifikasi"]');
        const tanggalInput = document.querySelector('[name="tanggal_arsip"]');
        const kodeDokumenInput = document.getElementById('kode_dokumen');

        function updateKodeDokumen() {
            const klasifikasi = $('#id_klasifikasi').val();
            const tanggal = tanggalInput.value;

            if (klasifikasi && tanggal) {
                fetch("/generate-kode-dokumen", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            klasifikasi,
                            tanggal_arsip: tanggal
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        kodeDokumenInput.value = data.kode_dokumen;
                    })
                    .catch(error => console.error('Gagal generate kode dokumen:', error));
            }
        }

        $('#id_klasifikasi').on('change', function() {
            updateKodeDokumen();
        });
        tanggalInput.addEventListener('change', updateKodeDokumen);
    </script>
    <script>
        const kataKunciInput = document.getElementById('kata_kunci_input');
        const kataKunciContainer = document.getElementById('kata_kunci_container');
        const kataKunciHidden = document.getElementById('kata_kunci_hidden');

        // Fungsi render tags
        function renderTags(tagsArray) {
            kataKunciContainer.innerHTML = '';

            tagsArray.forEach((tag, index) => {
                const tagElem = document.createElement('span');
                tagElem.className = 'badge bg-primary me-1 mb-1 d-flex align-items-center';
                tagElem.textContent = tag;

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn-close btn-close-white btn-sm ms-2';
                removeBtn.setAttribute('aria-label', 'Close');

                // Fungsi hapus tag
                removeBtn.onclick = () => {
                    tags.splice(index, 1); // <- langsung hapus dari array asli
                    updateTags(); // <- panggil ulang update
                };

                tagElem.appendChild(removeBtn);
                kataKunciContainer.appendChild(tagElem);
            });

            kataKunciHidden.value = JSON.stringify(tags);
        }

        // Fungsi update tags
        function updateTags() {
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

        $(document).ready(function() {
            // Init select2
            $('#id_klasifikasi').select2({
                placeholder: '- Pilih -',
                allowClear: true,
                width: '100%'
            });

            // Fungsi autofill via AJAX
            function autofill(id) {
                if (!id) {
                    $('#retensi_aktif, #retensi_inaktif, #retensi_keterangan, #klasifikasi_keamanan').val('');
                    // Ensure hitungBatasRetensi also clears or recalculates when ID is null
                    hitungBatasRetensi();
                    return;
                }
                $.ajax({
                    url: '/get-klasifikasi/' + id,
                    type: 'GET',
                    success: function(data) {
                        // Ensure data exists before setting values
                        if (data) {
                            $('#retensi_aktif').val(data.retensi_aktif);
                            $('#retensi_inaktif').val(data.retensi_inaktif);
                            $('#retensi_keterangan').val(data.retensi_keterangan);
                            $('#klasifikasi_keamanan').val(data.klasifikasi_keamanan);
                        } else {
                            // Clear fields if no data is returned for the ID
                            $('#retensi_aktif, #retensi_inaktif, #retensi_keterangan, #klasifikasi_keamanan').val('');
                        }
                        hitungBatasRetensi(); // Recalculate after setting new values
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching klasifikasi data:", error);
                        // Optionally clear fields on error too
                        $('#retensi_aktif, #retensi_inaktif, #retensi_keterangan, #klasifikasi_keamanan').val('');
                        hitungBatasRetensi();
                    }
                });
            }

            // --- CHANGE THIS PART ---
            // Use the standard 'change' event for Select2
            $('#id_klasifikasi').on('change', function() {
                autofill($(this).val());
            });
            // --- END CHANGE ---

            // The select2:clear event is fine if you specifically need separate logic for clearing.
            // If 'change' handles clearing adequately (by passing null if dropdown becomes empty),
            // you might not even need the 'select2:clear' listener.
            $('#id_klasifikasi').on('select2:clear', function() {
                autofill(null);
            });


            // Trigger autofill on page load for initial value
            // This call is correct for setting initial values when the page loads.
            autofill($('#id_klasifikasi').val());

            // Make sure your hitungBatasRetensi() function is also defined
            // and correctly updates #batas_status_retensi_aktif and #batas_status_retensi_inaktif.
            // I'm assuming you have this function defined elsewhere in your script.
            function hitungBatasRetensi() {
                // Your existing logic for calculating and setting these hidden fields
                const tanggalArsip = $('.datepicker').val(); // Get current tanggal_arsip
                const retensiAktif = parseInt($('#retensi_aktif').val());
                const retensiInaktif = parseInt($('#retensi_inaktif').val());

                if (tanggalArsip && !isNaN(retensiAktif) && !isNaN(retensiInaktif)) {
                    const date = new Date(tanggalArsip);
                    const batasAktif = new Date(date.getFullYear() + retensiAktif, date.getMonth(), date.getDate());
                    const batasInaktif = new Date(batasAktif.getFullYear() + retensiInaktif, batasAktif.getMonth(), batasAktif.getDate());

                    // Format dates to YYYY-MM-DD
                    const formatDate = (d) => {
                        const year = d.getFullYear();
                        const month = String(d.getMonth() + 1).padStart(2, '0');
                        const day = String(d.getDate()).padStart(2, '0');
                        return `${year}-${month}-${day}`;
                    };

                    $('#batas_status_retensi_aktif').val(formatDate(batasAktif));
                    $('#batas_status_retensi_inaktif').val(formatDate(batasInaktif));
                } else {
                    // Clear hidden fields if inputs are not valid
                    $('#batas_status_retensi_aktif').val('');
                    $('#batas_status_retensi_inaktif').val('');
                }
            }

            // Also trigger hitungBatasRetensi when tanggal_arsip changes
            $('.datepicker').on('change', function() {
                autofill($('#id_klasifikasi').val()); // Re-run autofill to ensure boundary dates are re-calculated
            });

            // Initialize datepicker (ensure this is configured if you haven't already)
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
        });




        // Preview multiple PDF upload
        document.getElementById('arsip_dokumen').addEventListener('change', function() {
            const files = this.files;
            const preview = document.getElementById('uploaded-files');
            preview.innerHTML = '';

            for (let i = 0; i < files.length; i++) {
                let file = files[i];
                if (file.type === 'application/pdf') {
                    let url = URL.createObjectURL(file);
                    let card = document.createElement('div');
                    card.className = 'col-lg-3 border rounded p-2';

                    card.innerHTML = `
                            <embed src="${url}" type="application/pdf" width="100%" height="150px" />
                            <p class="mt-1 mb-0 text-truncate" title="${file.name}">${file.name}</p>
                        `;
                    preview.appendChild(card);
                }
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const klasifikasiSelect = document.getElementById('klasifikasi_id');

            klasifikasiSelect.addEventListener('change', function() {
                const id = this.value;
                if (id) {
                    fetch(`/klasifikasi/get/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            document.getElementById('kode_klasifikasi').value = data.kode_klasifikasi || '';
                            document.getElementById('jenis_dokumen').value = data.jenis_dokumen || '';
                            document.getElementById('klasifikasi_keamanan').value = data.klasifikasi_keamanan || '';
                            document.getElementById('jangka_simpan').value = data.jangka_simpan || '';
                            document.getElementById('aktif').value = data.aktif || '';
                            document.getElementById('inaktif').value = data.inaktif || '';
                            document.getElementById('keterangan').value = data.keterangan || '';
                        })
                        .catch(err => {
                            console.error('Error:', err);
                        });
                }
            });
        });
    </script>

    <!--  -->
    <script>
        document.getElementById('klasifikasi_id').addEventListener('change', function() {
            const id = this.value;

            if (!id) {
                // Kosongkan semua field jika tidak ada pilihan
                document.getElementById('retensi_aktif').value = '';
                document.getElementById('retensi_inaktif').value = '';
                document.getElementById('klasifikasi_keamanan').value = '';
                document.getElementById('status_dokumen').value = '';
                document.getElementById('keterangan_penyusutan').value = '';
                return;
            }

            fetch('/klasifikasi/' + id + '/get')
                .then(response => {
                    if (!response.ok) throw new Error('Data tidak ditemukan');
                    return response.json();
                })
                .then(data => {
                    document.getElementById('retensi_aktif').value = data.retensi_aktif ?? '';
                    document.getElementById('retensi_inaktif').value = data.retensi_inaktif ?? '';
                    document.getElementById('klasifikasi_keamanan').value = data.klasifikasi_keamanan ?? '';
                    document.getElementById('status_dokumen').value = data.status_dokumen ?? '';
                    document.getElementById('keterangan_penyusutan').value = data.keterangan_penyusutan ?? '';
                })
                .catch(error => {
                    alert(error.message);
                    console.error(error);
                });
        });
    </script>



</x-app-layout>