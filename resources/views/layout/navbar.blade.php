<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="/">
      <img src="{{ asset('/storage/default-img/logo-ct.png') }}" alt="Logo" width="100" height="50" class="d-inline-block align-text-top">
      
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <!-- Selalu tampil -->
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('index') ? 'active' : '' }}" href="/"><i class="fa fa-home"></i> Beranda</a>
        </li>


        @guest
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}"><i class="fa fa-sign-in-alt"></i> Login</a>
          </li>
        @endguest

        @auth
          @if(auth()->user()->role === 'customer')
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('user.edit.profile') ? 'active' : '' }}" href="{{ Route('user.edit.profile') }}"><i class="fa fa-user"></i> Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('cek.keranjang') ? 'active' : '' }}" href="{{ Route('cek.keranjang') }}"><i class="fa fa-shopping-cart"></i> Keranjang</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('detail.pemesanan') ? 'active' : '' }}" href="{{ Route('detail.pemesanan') }}"><i class="fa fa-history"></i> Pemesanan</a>
            </li>
          @endif

          <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST" class="d-inline">@csrf
              <button class=" nav-link" type="submit"><i class="fa fa-power-off"></i> Logout</button>
            </form>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
