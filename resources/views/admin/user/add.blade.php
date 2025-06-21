    @extends('admin.layout.app')
    @section('content')
        <form action="{{ Route('add.user.proses') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">{{ $judul }}</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="nama">Nama</label><br>
                                <input type="text" class="form-control" name="nama" id="">
                            </div>
                            <div class="col-md-4">
                                <label for="nama">email</label><br>
                                <input type="text" class="form-control" name="email" id="">
                            </div>
                            <div class="col-md-4">
                                <label for="nama">Password</label><br>
                                <input type="password" class="form-control" name="password" id="">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="telepon">Telepon</label><br>
                                <input type="text" class="form-control" name="telepon" id="">
                            </div>
                            <div class="col-md-4">
                                <label for="alamat">Alamat</label><br>
                                <input type="text" class="form-control" name="alamat" id="">
                            </div>
                            <div class="col-md-4">
                                <label for="nama">Role</label><br>
                                <select name="role" id="" class="form-control">
                                    <option value="" selected disabled>-- Pilih Role --</option>
                                    <option value="admin">Admin</option>
                                    <option value="customer">Customer</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="nama">Foto</label><br>
                                <input class="form-control" type="file" name="foto" id="">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ Route('kelola.user') }}" class="btn btn-warning" style="width:100%;">Kembali</a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary" style="width:100%;">Tambah</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endsection
