@include('master.panel.header')
@include('master.panel.nav')

<!-- Main Content -->
<div class="content">
    <nav class="navbar navbar-light bg-white position-sticky p-0 top-0 d-flex align-items-center justify-content-between">
        <!-- Toggle Sidebar Mobile -->
        <div class="d-flex align-items-center ms-2 justify-content-center">
            <button class="btn fs-4 d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                <i class="iconsax" icon-name="hamburger-menu"></i>
            </button>
            @can('mahasiswa')
            <h5 class="ms-0 ms-md-3 mb-0 text-primary">Panel Mahasiswa</h5>
            @endcan
            @can('dosen')
            <h5 class="ms-0 ms-md-3 mb-0 text-primary">Panel Dosen</h5>
            @endcan
        </div>

        <!-- Nav User Right -->
        <div class="d-flex me-3 py-3 gap-2 align-items-center">
            <!-- Tombol Toggle Dark/Light -->
            <button id="toggleTheme" class="btn btn-nav d-flex align-items-center fs-4" title="Toggle Dark/Light Mode">
                <i class="iconsax" icon-name="moon"></i>
            </button>

            <!-- Profile Dropdown -->
            <button class="d-flex gap-2 align-items-center dropdown btn btn-nav" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{asset('assets/svg/profile-circle.svg')}}" class="nav-profile" alt="">
                <p class="nav-text text-capitalize d-md-block d-none">Halo, <span class="text-dark text-name">{{ Auth::user()->name }}</span></p>
                <i class="iconsax text-muted d-md-block d-none" icon-name="chevron-down"></i>
                <!-- Dropdown Menu User -->
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a class="dropdown-item text-danger" href="#" onclick="logout()">Logout</a></li>
                </ul>
            </button>
        </div>
    </nav>

    <div class="p-3">
        @yield('content')
    </div>

    <!-- Footer -->
    <div class="mt-5 mb-4 px-4">
        <p class="text-center text-muted" style="font-size: 14px;">All Rights Reserved by <strong class="text-primary">TPACK-IPA Inklusif</strong></p>
    </div>
</div>


@include('master.panel.footer')