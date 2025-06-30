<!-- Navbar -->

</style>
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3 d-flex justify-content-between align-items-center">
        <!-- Hamburger -->
            <button class="btn btn-outline-secondary d-md-none ms-3" type="button" data-bs-toggle="collapse" data-bs-target="#mobileSidebarMenu">
                <i class="fas fa-bars"></i>
            </button>
        <div class="d-flex align-items-center">
            <h6 class="font-weight-bolder mb-0">Dashboard</h6>
        </div>
        <!-- Profile & Logout tetap di kanan -->
        <div class="d-flex align-items-center">
            <a href="{{ Route('profile.edit.admin') }}" class="nav-link text-body font-weight-bold px-2">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">Profile</span>
            </a>
            <form action="{{ Route('logout') }}" method="POST" class="mb-0 ms-2">
                @csrf
                <button class="nav-link text-body font-weight-bold px-0" style="border: none; background-color:transparent">
                    <i class="fa fa-power-off me-sm-1"></i>
                    <span class="d-sm-inline d-none">Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Sidebar Items tampil vertikal di bawah saat mobile -->
<div class="collapse d-md-none px-4 pt-2" id="mobileSidebarMenu">
    <ul class="list-unstyled mobile-menu">
        <li><a class="d-block py-2" href="{{ Route('admin.index') }}"><i class="fa fa-home"></i> Dashboard</a></li>
        <li><a class="d-block py-2" href="{{ Route('kelola.user') }}"><i class="fa fa-user"></i> User</a></li>
        <li><a class="d-block py-2" href="{{ Route('kelola.produk') }}"><i class="fa fa-boxes-stacked"></i> Produk</a></li>
        <li><a class="d-block py-2" href="{{ Route('kelola.kategori') }}"><i class="fa fa-layer-group"></i> Kategori</a></li>
        <li><a class="d-block py-2" href="{{ Route('kelola.pesanan') }}"><i class="fa fa-cart-shopping"></i> Pesanan</a></li>
        <li><a class="d-block py-2" href="{{ Route('kelola.pembayaran') }}"><i class="fa fa-credit-card"></i> Pembayaran</a></li>
    </ul>
</div>
</nav>


<!-- End Navbar -->
