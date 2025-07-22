<x-app-layout>
    <x-slot:title>Dashboard</x-slot:title>

    {{-- Tabel Arsip berdasarkan role --}}
    <div class="card mt-4">
        <div class="card-body">
            @if (auth()->user()->role == 1)
            <x-form-title>
                <i class="ti ti-file-description fs-5 me-2"></i> {{ $totalArsip }} Arsip Butuh Diverifikasi
            </x-form-title>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Dokumen</th>
                            <th>Tanggal Upload</th>
                            <th>Status Dokumen</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($arsipTerbaru as $index => $arsip)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $arsip->nama_dokumen }}</td>
                            <td>{{ \Carbon\Carbon::parse($arsip->tanggal_arsip)->format('d-m-Y') }}</td>
                            <td>
                                @php
                                $badge = match ($arsip->verifikasi_arsip) {
                                'Verifikasi' => 'warning',
                                'Disetujui' => 'success',
                                'Direvisi' => 'danger',
                                default => 'secondary',
                                };
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ $arsip->verifikasi_arsip }}</span>
                            </td>
                            <td>
                                <a href="{{ route('arsip.show', $arsip->nomor_dokumen) }}"
                                    class="btn btn-primary btn-sm m-1" data-bs-tooltip="tooltip"
                                    data-bs-title="Tinjau dan Konfirmasi" aria-label="Tinjau dan Konfirmasi">
                                    <i class="ti ti-eye-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada arsip</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="text-end mt-3">
                <a href="{{ route('arsip.index') }}" class="btn btn-warning">
                    Lihat Selengkapnya <i class="ti ti-arrow-narrow-right"></i>
                </a>
            </div>
            @endif

            @if (in_array(auth()->user()->role, [2, 3, 4]))
            <x-form-title>
                <i class="ti ti-file-description fs-5 me-2"></i> {{ $totalArsip }} Arsip Terbaru
            </x-form-title>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Dokumen</th>
                            <th>Tanggal Upload</th>
                            @if (auth()->user()->role == 2)
                            <th>Tim Kerja</th>
                            @else
                            <th>Status Dokumen</th>
                            @endif
                            <th>Disetujui Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($arsipTerbaru as $index => $arsip)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $arsip->nama_dokumen }}</td>
                            <td>{{ \Carbon\Carbon::parse($arsip->tanggal_arsip)->format('d-m-Y') }}</td>
                            @if (auth()->user()->role == 2)
                            <td>{{ $arsip->user->nama_user }}</td>
                            @else
                            <td>{{ $arsip->verifikasi_arsip }}</td>
                            @endif
                            <td>{{ $arsip->disetujuiOlehUser->nama_user ?? 'Belum Disetujui' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada arsip</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @endif
        </div> {{-- end .card-body --}}
    </div> {{-- end .card --}}

    {{-- Tabel Arsip berdasarkan role --}}
    <div class="card mt-4">
        <div class="card-body">
            <x-form-title>
                <i class="ti ti-file-description fs-5 me-2"></i> Dokumen Per Klasifikasi
            </x-form-title>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Jenis Dokumen</th>
                            <th>Jumlah Arsip</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($arsipPerKlasifikasi as $item)
                        <tr>
                            <td>{{ $item->kode_klasifikasi }}</td>
                            <td>{{ $item->jenis_dokumen }}</td>
                            <td>{{ $item->jumlah }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada data klasifikasi arsip</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


        </div> {{-- end .card-body --}}
    </div> {{-- end .card --}}

    {{-- Hero Section --}}
    {{-- grafik jumlah arsip per tahun --}}
    <div class="card mt-4">
        <div class="card-body">
            <x-form-title>
                <i class="ti ti-chart-bar fs-5 me-2"></i> Jumlah Arsip Dokumen Per Tahun
            </x-form-title>
            <canvas id="grafikArsip" height="80"></canvas>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <x-form-title>
                <i class="ti ti-file-description fs-5 me-2"></i> Ringkasan Sistem Arsip
            </x-form-title>
            <div class="row">
                @php
                $user = auth()->user();
                @endphp

                @if (in_array($user->role, [1, 2, 3]))
                {{-- Untuk role 1, 2, 3 tampilkan semua statistik --}}
                <div class="col-md-6 mb-4">
                    <x-card-stats
                        icon="ti ti-archive"
                        color="primary"
                        title="Total Arsip Dokumen"
                        :value="$totalSeluruhArsip"
                        route="arsip.index" />
                </div>

                <div class="col-md-6 mb-4">
                    <x-card-stats
                        icon="ti ti-check"
                        color="success"
                        title="Arsip Aktif"
                        :value="$totalArsipAktif"
                        route="arsip.index" />
                </div>

                <div class="col-md-6 mb-4">
                    <x-card-stats
                        icon="ti ti-alert-triangle"
                        color="warning"
                        title="Arsip Inaktif"
                        :value="$totalArsipKadaluarsa"
                        route="kadaluarsa.index" />
                </div>

                <div class="col-md-6 mb-4">
                    <x-card-stats
                        icon="ti ti-trash"
                        color="danger"
                        title="Arsip Musnah"
                        :value="$totalArsipMusnah"
                        route="musnah.index" />
                </div>

                {{-- Ringkasan Arsip per Operator --}}
                @foreach (\App\Models\User::where('role', 4)->get() as $operator)
                <div class="col-md-6 mb-4">
                    <x-card-stats
                        icon="ti ti-file-text-spark"
                        color="info"
                        title="Arsip oleh {{ $operator->nama_user }}"
                        :value="$operator->arsipDibuat()->count() . ' dokumen'"
                        route="arsip.index" />
                </div>
                @endforeach

                @elseif ($user->role == 4)
                {{-- Untuk role 4 tampilkan hanya data miliknya sendiri --}}
                <div class="col-md-6 mb-4">
                    <x-card-stats
                        icon="ti ti-archive"
                        color="primary"
                        title="Total Arsip Anda"
                        :value="$totalArsip . ' dokumen'"
                        route="arsip.index" />
                </div>

                <div class="col-md-6 mb-4">
                    <x-card-stats
                        icon="ti ti-check"
                        color="success"
                        title="Arsip Aktif"
                        :value="$totalArsipAktif . ' dokumen'"
                        route="arsip.index" />
                </div>

                <div class="col-md-6 mb-4">
                    <x-card-stats
                        icon="ti ti-alert-triangle"
                        color="warning"
                        title="Arsip Inaktif"
                        :value="$totalArsipKadaluarsa . ' dokumen'"
                        route="kadaluarsa.index" />
                </div>

                <div class="col-md-6 mb-4">
                    <x-card-stats
                        icon="ti ti-trash"
                        color="danger"
                        title="Arsip Musnah"
                        :value="$totalArsipMusnah . ' dokumen'"
                        route="musnah.index" />
                </div>
                @endif
            </div>
        </div>
    </div>

    <script type="application/javascript">
        // Data dari controller, sudah disiapkan sesuai role
        const chartLabels = @json($arsipPerTahun -> pluck('tahun'));
        const chartData = @json($arsipPerTahun -> pluck('jumlah'));

        Chart.defaults.font.family = 'Nunito, sans-serif';
        Chart.defaults.font.size = 14;

        const ctx = document.getElementById('grafikArsip').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Jumlah Arsip',
                    data: chartData,
                    backgroundColor: 'rgba(99, 91, 255, 0.6)',
                    hoverBackgroundColor: 'rgba(99, 91, 255, 1)',
                    borderRadius: 12,
                    maxBarThickness: 50,
                    borderWidth: 1,
                    borderSkipped: false
                }]
            },
            options: {
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            tickBorderDash: [2]
                        },
                        border: {
                            display: false,
                            dash: [2]
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        titleMarginBottom: 10,
                        padding: 15,
                        boxPadding: 7,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ' : ' + context.parsed.y + ' Dokumen';
                            }
                        }
                    }
                }
            }
        });
    </script>

</x-app-layout>