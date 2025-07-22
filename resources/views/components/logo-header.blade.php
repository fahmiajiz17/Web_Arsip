<div class="logo-header" data-background-color="white">
    {{-- Logo --}}
    <a href="https://lldikti4.id/" class="logo">
        <img src="{{ asset('storage/logo/' . $profil->logo_instansi) }}" alt="Logo Instansi" class="navbar-brand me-2" height="30">
    </a>
    {{-- Toggle Nav --}}
    <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar">
            <i class="gg-menu-right"></i>
        </button>
        <button class="btn btn-toggle sidenav-toggler">
            <i class="gg-menu-left"></i>
        </button>
    </div>
    <button class="topbar-toggler more">
        <i class="gg-more-vertical-alt"></i>
    </button>
</div>