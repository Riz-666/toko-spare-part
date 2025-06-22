<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="/">
      <img src="{{ asset('/storage/default-img/logo-ct.png') }}" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
      Project
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <!-- Selalu tampil -->
        <li class="nav-item">
          <a class="nav-link" href="/"><i class="fa fa-home"></i> Beranda</a>
        </li>


        @guest
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}"><i class="fa fa-sign-in-alt"></i> Login</a>
          </li>
        @endguest

        @auth
          @if(auth()->user()->role === 'customer')
            <li class="nav-item">
              <a class="nav-link" href="{{ Route('profile.edit') }}"><i class="fa fa-user"></i> Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ Route('cek.keranjang') }}"><i class="fa fa-shopping-cart"></i> Keranjang</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ Route('detail.pemesanan') }}"><i class="fa fa-history"></i> Pemesanan</a>
            </li>
          @endif

          <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST" class="d-inline">@csrf
              <button class="btn btn-link nav-link" type="submit"><i class="fa fa-power-off"></i> Logout</button>
            </form>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
