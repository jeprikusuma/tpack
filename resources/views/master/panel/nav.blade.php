<!-- Sidebar Desktop -->
<div class="sidebar d-none d-lg-block bg-white shadow py-4 px-0" id="sidebar">
    <!-- Logo -->
        <div class="px-4 mb-5 mt-3">
            <h4 class="text-primary fw-bold">TPACK-IPA <br/> Inklusif</h4>
        </div>

    <!-- Sidebar Menu -->
    <p class="sidebar-group">MENU UTAMA</p>
    @can('mahasiswa')
        @include('master.panel.nav_mahasiswa')
    @else
        @include('master.panel.nav_dosen')
    @endcan
    <!-- Sidebar Menu -->
    <p class="sidebar-group mt-4">AKUN</p>
    <a class="siderbar-menu text-danger" href="#" onclick="logout()">
        <div>
            <i class="iconsax me-2" icon-name="logout-1"></i>
            Logout
        </div>
    </a>
</div>

<!-- Offcanvas Sidebar Mobile -->
<div class="offcanvas offcanvas-start p-0" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasMenuLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div id="sidebarMobile"></div>
</div>