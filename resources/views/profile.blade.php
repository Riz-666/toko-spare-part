@extends('admin.layout.app')

@section('content')

    <div class="container mt-4">
    <h3>Edit Profil</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $user->nama) }}" required>
        </div>

        <div class="form-group mt-2">
            <label>Telepon</label>
            <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $user->telepon) }}" required>
        </div>

        <div class="form-group mt-2">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required>{{ old('alamat', $user->alamat) }}</textarea>
        </div>

        <div class="form-group mt-2">
            <label>Foto Profil</label>
            @if ($user->foto)
                <div class="mb-2">
                    <img src="{{ asset('storage/user-img/' . $user->foto) }}" width="100">
                </div>
                @else
                <div class="mb-2">
                    <img src="{{ asset('storage/default-img/user-default.jpg') }}" width="100">
                </div>
            @endif
            <input type="file" name="foto" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
</div>

@endsection
