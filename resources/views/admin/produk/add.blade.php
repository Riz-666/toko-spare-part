    @extends('admin.layout.app')
    @section('content')
        <form action="{{ Route('add.produk.proses') }}" method="POST" enctype="multipart/form-data">
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
                            <div class="col-md-6">
                                <label for="kategori">Kategori</label><br>
                                <select name="kategori_id" id="" class="form-control">
                                    <option value="" selected disabled>-- Pilih Kategori --</option>
                                    @foreach ($kategori as $ktg)
                                    <option value="{{ $ktg->id }}">{{ $ktg->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="nama_produk">Nama Produk</label><br>
                                <input type="text" class="form-control" name="nama" value="{{ old('nama') }}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="nama">Deskripsi</label><br>
                                <textarea name="deskripsi" id="ckeditor"></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="telepon">Stok</label><br>
                                <input type="number" class="form-control" name="stok" id="" value="{{ old('stok') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="alamat">Harga</label><br>
                                <input type="number" class="form-control" name="harga" id="" value="{{ old('harga') }}">
                            </div>
                            <div class="col-md-12">
                                <label for="foto">Foto</label><br>
                                <input class="form-control" type="file" name="gambar" id="">
                                @error('gambar')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ Route('kelola.produk') }}" class="btn btn-warning" style="width:100%;">Kembali</a>
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
