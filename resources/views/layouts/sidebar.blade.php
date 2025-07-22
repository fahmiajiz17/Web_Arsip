<div class="sidebar sidebar-style-2" data-background-color="white">
    {{-- Sidebar Logo --}}
    <div class="sidebar-logo">
        {{-- Logo Header --}}
        <x-logo-header></x-logo-header>
    </div>

    {{-- Sidebar Menu --}}
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-primary">
                <li class="nav-item">
                    <x-sidebar-link href="{{ route('dashboard.index') }}" :active="request()->routeIs('dashboard.index')">
                        <i class="ti ti-layout-dashboard"></i>
                        <p>Dashboard</p>
                    </x-sidebar-link>
                </li>

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="ti ti-dots fs-5"></i>
                    </span>
                    <h4 class="text-section">Arsip</h4>
                </li>
                <li class="nav-item">
                    <x-sidebar-link href="{{ route('arsip.index') }}" :active="request()->routeIs('arsip.*')">
                        <i class="ti ti-archive"></i>
                        <p>Arsip Dokumen</p>
                    </x-sidebar-link>
                </li>

                @if (auth()->user()->role == 3)
                <li class="nav-item">
                    <x-sidebar-link href="{{ route('kadaluarsa.index') }}" :active="request()->routeIs('kadaluarsa.*')">
                        <i class="ti ti-file-text"></i>
                        <p>Arsip Dokumen Inaktif</p>
                    </x-sidebar-link>
                </li>
                <li class="nav-item">
                    <x-sidebar-link href="{{ route('musnah.index') }}" :active="request()->routeIs('musnah.*')">
                        <i class="ti ti-file-shredder"></i>
                        <p>Arsip Dokumen Musnah</p>
                    </x-sidebar-link>
                </li>
                @endif

                {{-- tampilkan menu jika role = Administrator atau Pengelola Arsip --}}
                @if (auth()->user()->role == 1 || auth()->user()->role == 2 || auth()->user()->role == 4 || auth()->user()->role == 5 || auth()->user()->role == 6)
                <li class="nav-item">
                    <x-sidebar-link href="{{ route('kadaluarsa.index') }}" :active="request()->routeIs('kadaluarsa.*')">
                        <i class="ti ti-file-text"></i>
                        <p>Arsip Dokumen Inaktif</p>
                    </x-sidebar-link>
                </li>
                <li class="nav-item">
                    <x-sidebar-link href="{{ route('musnah.index') }}" :active="request()->routeIs('musnah.*')">
                        <i class="ti ti-file-shredder"></i>
                        <p>Arsip Dokumen Musnah</p>
                    </x-sidebar-link>
                </li>
                @if (auth()->user()->role == 1)
                <li class="nav-item">
                    <x-sidebar-link href="{{ route('dasarhukum.index') }}" :active="request()->routeIs('dasarhukum.*')">
                        <i class="ti ti-gavel"></i>
                        <p>Dasar Hukum</p>
                    </x-sidebar-link>
                </li>
                <li class="nav-item">
                    <x-sidebar-link href="{{ route('klasifikasi.index') }}" :active="request()->routeIs('klasifikasi.*')">
                        <i class="ti ti-category"></i>
                        <p>Klasifikasi Arsip</p>
                    </x-sidebar-link>
                </li>
                @endif
                @if (auth()->user()->role == 1 || auth()->user()->role == 2 || auth()->user()->role == 3 || auth()->user()->role == 4)
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="ti ti-dots fs-5"></i>
                    </span>
                    <h4 class="text-section">Log</h4>
                </li>
                <li class="nav-item">
                    <x-sidebar-link href="{{ route('log-aktivitas.index') }}" :active="request()->routeIs('log-aktivitas.*')">
                        <i class="ti ti-activity"></i>
                        <p>Aktivitas</p>
                    </x-sidebar-link>
                </li>
                @endif

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="ti ti-dots fs-5"></i>
                    </span>
                    <h4 class="text-section">Panduan</h4>
                </li>
                <li class="nav-item">
                    <x-sidebar-link href="{{ route('panduan.index') }}" :active="request()->routeIs('panduan.*')">
                        <i class="ti ti-help-square-rounded"></i>
                        <p>Panduan Penggunaan</p>
                    </x-sidebar-link>
                </li>
                @endif

                {{-- tampilkan menu jika role = KABAG --}}
                @if (auth()->user()->role == 2)
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="ti ti-dots fs-5"></i>
                    </span>
                    <h4 class="text-section">Pengaturan</h4>
                </li>
                <li class="nav-item">
                    <x-sidebar-link href="{{ route('role.role') }}" :active="request()->routeIs('role.*')">
                        <i class="ti ti-user"></i>
                        <p>Manajemen Role</p>
                    </x-sidebar-link>
                </li>
                <li class="nav-item">
                    <x-sidebar-link href="{{ route('user.index') }}" :active="request()->routeIs('user.*')">
                        <i class="ti ti-user-plus"></i>
                        <p>Manajemen User</p>
                    </x-sidebar-link>
                </li>
                <li class="nav-item">
                    <x-sidebar-link href="{{ route('profil.index') }}" :active="request()->routeIs('profil.*')">
                        <i class="ti ti-home-cog"></i>
                        <p>Profil Instansi</p>
                    </x-sidebar-link>
                </li>

                @endif
            </ul>
        </div>
    </div>
</div>