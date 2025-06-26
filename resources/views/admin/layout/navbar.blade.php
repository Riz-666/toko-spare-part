<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">

            <h6 class="font-weight-bolder mb-0">Dashboard</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <a href="{{ Route('profile.edit.admin') }}" class="nav-link text-body font-weight-bold px-0">
                        <i class="fa fa-user me-sm-1"></i>
                        <span class="d-sm-inline d-none">Profile</span>
                    </a>
            </div>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <form action="{{ Route('logout') }}" method="POST">
                        @csrf
                    <button class="nav-link text-body font-weight-bold px-0" style="border: none; background-color:transparent">
                        <i class="fa fa-power-off me-sm-1"></i>
                        <span class="d-sm-inline d-none">Logout</span>
                    </button>
                </li>
                </form>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->
