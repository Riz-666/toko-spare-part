@extends('admin.layout.app')
@section('content')
    <form action="{{ Route('edit.user.proses', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">{{ $judul }}</h5>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="nama">Nama</label><br>
                            <input type="text" class="form-control" name="nama" value="{{ old('nama'),$user->nama }}">
                        </div>
                        <div class="col-md-4">
                            <label for="nama">email</label><br>
                            <input type="text" class="form-control" name="email" value="{{ old('email'),$user->email }}">
                        </div>
                        <div class="col-md-4">
                            <label for="nama">Password</label><br>
                            <input type="password" class="form-control" name="password">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="telepon">Telepon</label><br>
                            <input type="text" class="form-control" name="telepon" value="{{ old('telepon'),$user->telepon }}">
                        </div>
                        <div class="col-md-4">
                            <label for="alamat">Alamat</label><br>
                            <input type="text" class="form-control" name="alamat" value="{{ old('alamat'),$user->alamat }}">
                        </div>
                        <div class="col-md-4">
                            <label for="nama">Role</label><br>
                            <select name="role" id="" class="form-control">
                                <option value="" disabled>-- Pilih Role --</option>
                                <option value="admin"{{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin
                                </option>
                                <option value="customer" {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>
                                    Customer</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="nama">Foto</label><br>
                            <input class="form-control" type="file" name="foto" value="{{ $user->foto }}">
                            @error('foto')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                            <input class="form-control" type="text" value="{{ $user->foto }}" disabled>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ Route('kelola.user') }}" class="btn btn-warning" style="width:100%;">Kembali</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary" style="width:100%;">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </div>
    </form>
@endsection
