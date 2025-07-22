<x-app-layout>
    <x-slot:title>Log Aktivitas</x-slot:title>

    <div class="card">
        <div class="card-body">
            <div class="d-sm-flex flex-sm-row justify-content-between align-items-center mb-4">
                {{-- form pencarian di kiri --}}
                <form action="" method="GET" class="row row-cols-lg-auto g-2 align-items-center mb-3">
                    <div class="col">
                        <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Pencarian..." autocomplete="off">
                    </div>
                    <div class="col">
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col">
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-search"></i> Filter
                        </button>
                    </div>
                    <div class="col">
                        <a href="{{ route('log-aktivitas.index') }}" class="btn btn-secondary">
                            Reset
                        </a>
                    </div>

                </form>


                {{-- kalau mau isi lain di kanan, misal tombol atau info, bisa ditambah di sini --}}
            </div>
            <div class="table-responsive border rounded mb-4">
                <table class="table align-middle text-nowrap mb-0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Aktivitas</th>
                            <th>Username</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->timezone('Asia/Jakarta')->format('d-m-Y') }}</td>
                            <td>{{ $log->created_at->timezone('Asia/Jakarta')->format('H:i:s') }}</td>
                            <td style="white-space: normal; word-wrap: break-word; max-width: 300px;">
                                {{ $log->aktivitas }}
                            </td>
                            <td><span class="badge bg-warning">{{ $log->user->username }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $logs->links() }}
        </div>
    </div>
</x-app-layout>