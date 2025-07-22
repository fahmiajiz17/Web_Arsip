<x-app-layout>
    <x-slot:title>Arsip Dokumen</x-slot:title>
    <x-slot:breadcrumb>Detail</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">
            <x-form-title>
                <i class="ti ti-list fs-5 me-2"></i> Detail Arsip Dokumen
            </x-form-title>

            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="table-responsive border rounded mb-4">
                <table class="table align-middle text-nowrap mb-0">
                    <tr>
                        <td width="150">Kode Dokumen</td>
                        <td width="10">:</td>
                        <td>{{ $arsip->kode_dokumen }}</td>
                    </tr>
                    <tr>
                        <td>Nama Dokumen</td>
                        <td>:</td>
                        <td>{{ $arsip->nama_dokumen }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Upload</td>
                        <td>:</td>
                        <td> {{ \Carbon\Carbon::parse($arsip->tanggal_arsip)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <td>Deskripsi</td>
                        <td>:</td>
                        <td>{{ $arsip->deskripsi_arsip }}</td>
                    </tr>
                    <tr>
                        <td>Dasar Hukum</td>
                        <td>:</td>
                        <td>{{ $arsip->dasarHukum->nama_dasar_hukum ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Klasifikasi</td>
                        <td>:</td>
                        <td>{{ $arsip->klasifikasiData->kode_klasifikasi ?? '-' }} -
                            {{ $arsip->klasifikasiData->jenis_dokumen ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Status Dokumen</td>
                        <td>:</td>
                        <td>{{ $arsip->status_dokumen }}</td>
                    </tr>
                    <tr>
                        <td>Batas Retensi Aktif</td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($arsip->batas_status_retensi_aktif)->format('d-m-Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td>Batas Retensi Inaktif</td>
                        <td>:</td>
                        <td> {{ \Carbon\Carbon::parse($arsip->batas_status_retensi_inaktif)->format('d-m-Y') }}</td>
                        </td>
                    </tr>
                    <tr>
                        <td>Tanggal Pembuatan</td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($arsip->created_at)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <td>Status Arsip</td>
                        <td>:</td>
                        <td>
                            @if ($arsip->verifikasi_arsip === 'Verifikasi')
                            <span class="badge bg-warning">{{ $arsip->verifikasi_arsip }}</span>
                            @elseif ($arsip->verifikasi_arsip === 'Disetujui')
                            <span class="badge bg-success">{{ $arsip->verifikasi_arsip }}</span>
                            @elseif ($arsip->verifikasi_arsip === 'Direvisi')
                            <span class="badge bg-danger">{{ $arsip->verifikasi_arsip }}</span>
                            @else
                            <span class="badge bg-secondary">{{ $arsip->verifikasi_arsip }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Kata Kunci</td>
                        <td>:</td>
                        <td>{{ $arsip->kata_kunci }}</td>
                    </tr>
                    <tr>
                        <td>Tim Kerja</td>
                        <td>:</td>
                        <td>{{ $arsip->user->nama_user }}</td>
                    </tr>

                    <tr>
                        <td>Catatan</td>
                        <td>:</td>
                        <td>{{ $arsip->catatan_revisi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Disetujui Oleh</td>
                        <td>:</td>
                        <td>{{ $arsip->disetujuiOlehUser->nama_user ?? '-' }}</td>
                    </tr>
                </table>
            </div>

            {{-- Tampilkan Daftar Dokumen --}}
            @php
            $files = is_string($arsip->arsip_dokumen)
            ? json_decode($arsip->arsip_dokumen, true)
            : $arsip->arsip_dokumen;
            @endphp

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" width="50">No</th>
                            <th>Nama File</th>
                            <th class="text-center" width="120">File</th>
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
                                <div class="modal fade" id="modalPreview{{ $index }}" tabindex="-1"
                                    aria-labelledby="modalLabel{{ $index }}" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel{{ $index }}">File:
                                                    {{ $file }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" style="height: 80vh;">
                                                <iframe src="{{ asset('storage/dokumen/' . $file) }}"
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

            <div class="d-flex align-items-center gap-2 mt-3">
                <!-- Tombol Kembali -->
                <a href="{{ route('kadaluarsa.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left me-1"></i> Kembali
                </a>

                @if (auth()->user()->role == 4 && $arsip->verifikasi_arsip === 'Direvisi')
                <form action="{{ route('arsip.revisi-ulang', $arsip->nomor_dokumen) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-warning">
                        <i class="ti ti-pencil me-1"></i> Edit Arsip
                    </button>
                </form>
                @endif


                @if (auth()->user()->role == 1 && $arsip->verifikasi_arsip === 'Verifikasi')
                <!-- Form Verifikasi -->
                <form id="formVerifikasi" action="{{ route('arsip.verifikasi', $arsip->nomor_dokumen) }}"
                    method="POST" class="d-flex gap-2 align-items-center">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="verifikasi_arsip" id="verifikasi_arsip" value="">
                    <textarea name="catatan_revisi" id="catatan_revisi" class="d-none"></textarea>
                    <button type="button" class="btn btn-success" id="btnDisetujui">
                        <i class="ti ti-check me-1"></i> Disetujui
                    </button>
                    <button type="button" class="btn btn-danger" id="btnDirevisi">
                        <i class="ti ti-x me-1"></i> Direvisi
                    </button>
                </form>


                <!-- Modal Catatan Revisi -->
                <div class="modal fade" id="modalCatatanRevisi" tabindex="-1"
                    aria-labelledby="modalCatatanRevisiLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCatatanRevisiLabel">Catatan Revisi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <textarea id="textareaCatatan" class="form-control" rows="5" placeholder="Masukkan catatan revisi di sini..."></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-primary" id="btnSaveCatatan">Simpan
                                    Catatan</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Konfirmasi -->
                <div class="modal fade" id="modalKonfirmasi" tabindex="-1"
                    aria-labelledby="modalKonfirmasiLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalKonfirmasiLabel">Konfirmasi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body" id="modalKonfirmasiBody">
                                <!-- Isi pesan konfirmasi dinamis akan dimasukkan di sini -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-primary" id="btnKonfirmasiOk">Ya</button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const formVerifikasi = document.getElementById('formVerifikasi');
                        const inputVerifikasi = document.getElementById('verifikasi_arsip');
                        const inputCatatan = document.getElementById('catatan_revisi');
                        const modalKonfirmasi = new bootstrap.Modal(document.getElementById('modalKonfirmasi'));
                        const modalCatatan = new bootstrap.Modal(document.getElementById('modalCatatanRevisi'));
                        const modalKonfirmasiBody = document.getElementById('modalKonfirmasiBody');
                        const textareaCatatan = document.getElementById('textareaCatatan');

                        let aksi = ''; // 'disetujui' atau 'direvisi'

                        document.getElementById('btnDisetujui').addEventListener('click', function() {
                            aksi = 'Disetujui';
                            modalKonfirmasiBody.textContent = 'Apakah Anda yakin ingin menyetujui arsip dokumen ini?';
                            modalKonfirmasi.show();
                        });

                        document.getElementById('btnDirevisi').addEventListener('click', function() {
                            aksi = 'Direvisi';
                            modalCatatan.show();
                        });

                        document.getElementById('btnSaveCatatan').addEventListener('click', function() {
                            const catatan = textareaCatatan.value.trim();
                            if (catatan === '') {
                                alert('Catatan revisi tidak boleh kosong.');
                                return;
                            }

                            // Simpan catatan, kemudian tampilkan konfirmasi
                            inputCatatan.value = catatan;
                            modalCatatan.hide();
                            modalKonfirmasiBody.textContent =
                                'Apakah Anda yakin ingin mengirim dokumen untuk direvisi?';
                            modalKonfirmasi.show();
                        });

                        document.getElementById('btnKonfirmasiOk').addEventListener('click', function() {
                            inputVerifikasi.value = aksi;
                            formVerifikasi.submit();
                        });
                    });
                </script>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>