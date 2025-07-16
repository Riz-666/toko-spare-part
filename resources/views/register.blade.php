@extends('layout.app')

@section('content')
    <div class="container mt-4">

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan!</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.submit') }}" method="POST">
            @csrf
            <div class="card text-center">
                <div class="card-title" style="background-color: gainsboro; height:90px">
                    <h3 class="mt-4">Daftar Akun</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-2">
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control" placeholder="Masukan Nama" value="{{ old('nama') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-2">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Masukan Email" value="{{ old('email') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-2">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Masukan Password" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-2">
                                <label>Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-2">
                                <label>Telepon</label>
                                <input type="number" name="telepon"  placeholder="Masukan No. Telepon" class="form-control" value="{{ old('telepon') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-2">
                                <label>Alamat</label>
                                <textarea name="alamat" placeholder="Masukan Alamat" class="form-control" >{{ old('alamat') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3" style="width:100%">Daftar</button>
                </div>
            </div>

        </form>
    </div>
@endsection
