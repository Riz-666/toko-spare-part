    @extends('admin.layout.app')
    @section('content')
        <form action="{{ Route('add.kategori.proses') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">{{ $judul }}</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="nama_produk">Nama Kategori</label><br>
                                <input type="text" class="form-control" name="nama">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ Route('kelola.produk') }}" class="btn btn-warning"
                                    style="width:100%;">Kembali</a>
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
