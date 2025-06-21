    @extends('admin.layout.app')
    @section('content')
        <form action="{{ Route('edit.produk.proses', $edit->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
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
                                        <option value="{{ $ktg->id }}"
                                            {{ old('kategori_id', $edit->kategori_id) == $ktg->id ? 'selected' : '' }}>
                                            {{ $ktg->nama }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-6">
                                <label for="nama_produk">Nama Produk</label><br>
                                <input type="text" class="form-control" name="nama"
                                    value="{{ old('nama', $edit->nama ?? '') }}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="nama">Deskripsi</label><br>
                                <textarea name="deskripsi" id="ckeditor" value="">{{ old('deskripsi', $edit->deskripsi ?? '') }}</textarea>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="telepon">Stok</label><br>
                                <input type="number" class="form-control" name="stok"
                                    value="{{ old('stok', $edit->stok ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="alamat">Harga</label><br>
                                <input type="number" class="form-control" name="harga"
                                    value="{{ old('harga', $edit->harga ?? '') }}">
                            </div>
                            <div class="col-md-12">
                                <label for="foto">Foto</label><br>
                                <input class="form-control" type="file" name="gambar" id="">
                                <input type="text" class="form-control" disabled
                                    value="{{ old('gambar', $edit->gambar ?? '') }}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ Route('kelola.produk') }}" class="btn btn-warning"
                                    style="width:100%;">Kembali</a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary" style="width:100%;">Simpan Perubahan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endsection
