@extends('admin.layout.app')
@section('content')


<div class="container">
    <div class="alert alert-primary" style="color: white">
  <div class="card-body">
    <h3 class="card-title" style="color: white">Selamat Datang {{ Auth::user()->nama }}</h3>
    <p class="card-text">
        <p style="color: white">
        Halo <b>{{ Auth::user()->nama }},</b> pada aplikasi Toko Online dengan hak akses yang anda miliki sebagai
        <b>
            @if (Auth::user()->role == "admin")
                Super Admin
            @elseif (Auth::user()->role == "customer")
                Admin
            @endif
        </b>
        ini adalah halaman utama dari aplikasi ini.
    </p>
  </div>
</div>


    <!-- Form logout yang disembunyikan -->
    <form id="keluar-app" action="" method="POST" class="d-none">
        @csrf
    </form>
    <!-- keluarAppEnd -->
</div>

@endsection
