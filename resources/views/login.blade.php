@extends('layout.app')
@section('content')
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-login">
                    <h3 class="text-center mb-3 fw-bold text-primary">Login</h3>
                    <p class="text-center text-muted mb-4">Masukan Email Dan Password Untuk Login</p>
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Form Login -->
                    <form method="POST" action="{{ Route('auth') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Email" required
                                autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="password" required>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="remember" id="remember" class="form-check-input">
                            <label for="remember" class="form-check-label">Tetap Masuk</label>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Masuk</button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <small>Belum Punya Akun? <a href="{{ Route('register.form') }}">Daftar</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
