<nav class="navbar navbar-expand-lg bg-white sticky-top shadow-sm">
  <div class="container">
    <!-- Logo kiri -->
    <a class="navbar-brand" href="#">
      <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" height="46" class="d-inline-block align-text-top">
    </a>

    <!-- Toggle button (untuk mobile) -->
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
      aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <!-- Nav tengah -->
        <ul class="navbar-nav mx-auto gap-4">
          <li class="nav-item">
            <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" aria-current="page" href="/">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('content') ? 'active' : '' }}" href="/content">Contents</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('partner') ? 'active' : '' }}" href="/partner">Our Partners</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('workflow') ? 'active' : '' }}" href="/workflow">How it works</a>
          </li>
        </ul>

        <!-- Button kanan -->
        <a href="{{ route('login') }}" class="btn btn-primary ms-lg-3 mt-3 mt-md-0 px-5 rounded-pill col-12 col-md-2">Login</a>
      </div>
    </div>
  </div>
</nav>
