<x-app-layout>
    <x-slot:title>Halaman Dashboard Login</x-slot:title>

    <div class="card">
        <div class="card-body">
            {{-- judul form --}}
            <x-form-title>
                <i class="ti ti-list fs-5 me-2"></i> Halaman Dashboard Login
            </x-form-title>

            {{-- menampilkan pesan berhasil --}}
            <x-alert></x-alert>

            {{-- tampilkan data --}}
            <div class="row mb-n25">
                <div class="col-12">
                    <div class="table-responsive border rounded mb-4">
                        <table class="table align-middle text-nowrap mb-0">
                            <tr>
                                <td width="150">Nama Aplikasi</td>
                                <td width="10">:</td>
                                <td>{{ $profil->nama_aplikasi }}</td>
                            </tr>
                            <tr>
                                <td width="150">Kepanjangan Nama Aplikasi</td>
                                <td width="10">:</td>
                                <td>{{ $profil->kepanjangan_aplikasi }}</td>
                            </tr>
                            <tr>
                                <td width="150">Copyright</td>
                                <td width="10">:</td>
                                <td>{{ $profil->nama_copyright }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Bagian Logo, buat sejajar di bawah --}}
                <div class="col-12 d-flex justify-content-center">
                    <div class="d-flex justify-content-around w-50">
                        {{-- Logo Instansi --}}
                        <div class="border rounded text-center p-3 mx-2">
                            @if ($profil->logo_instansi)
                                <img src="{{ asset('storage/logo/' . $profil->logo_instansi) }}" class="img-fluid p-2"
                                    width="150" alt="Logo Instansi">
                            @else
                                <img src="{{ asset('/images/default-logo.png') }}" class="img-fluid p-2" width="150"
                                    alt="Logo Instansi">
                            @endif
                            <p>Logo Instansi</p>
                        </div>

                        {{-- Logo Kerjasama --}}
                        <div class="border rounded text-center p-3 mx-2">
                            @if ($profil->logo_kerjasama)
                                <img src="{{ asset('storage/logo/' . $profil->logo_kerjasama) }}" class="img-fluid p-2"
                                    width="150" alt="Logo Kerjasama">
                            @else
                                <img src="{{ asset('/images/default-logo.png') }}" class="img-fluid p-2" width="150"
                                    alt="Logo Kerjasama">
                            @endif
                            <p>Logo Kerjasama</p>
                        </div>
                    </div>
                </div>
            </div>


            {{-- action buttons --}}
            <x-form-action-buttons>profil</x-form-action-buttons>
        </div>
    </div>
</x-app-layout>
