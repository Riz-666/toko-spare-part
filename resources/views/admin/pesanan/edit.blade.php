@extends('admin.layout.app')
@section('content')
    <form action="{{ Route('edit.pesanan.proses', $pesanan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">{{ $judul }}</h5>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="nama">Nama pesanan</label><br>
                            <input type="text" class="form-control" name="user_id" disabled value="{{ $pesanan->user->nama }}">
                        </div>
                        <div class="col-md-4">
                            <label for="nama">Kode Pesanan</label><br>
                            <input type="text" class="form-control" name="kode_pesanan" disabled value="{{ $pesanan->kode_pesanan }}">
                        </div>
                        <div class="col-md-4">
                            <label for="nama">Total</label><br>
                            <input type="text" class="form-control" name="total" disabled value="{{ $pesanan->total }}">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="telepon">Metode Pembayaran</label><br>
                            <input type="text" class="form-control" name="metode_pembayaran" value="{{ $pesanan->pembayaran->metode ?? 'Belum Di Pilih' }}"  disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="alamat">Alamat Pengiriman</label><br>
                            <input type="text" class="form-control" name="alamat_pengiriman" value="{{ $pesanan->alamat_pengiriman }}"  disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="nama">Status</label><br>
                            <select name="status" id="" class="form-control">
                                <option value="menunggu"{{ old('status', $pesanan->status) == 'menunggu' ? 'selected' : '' }}>Menunggu
                                </option>
                                <option value="diproses" {{ old('status', $pesanan->status) == 'diproses' ? 'selected' : '' }}>
                                    Di Proses</option>
                                    <option value="dikirim"{{ old('status', $pesanan->status) == 'dikirim' ? 'selected' : '' }}>dikirim
                                </option>
                                <option value="selesai"{{ old('status', $pesanan->status) == 'selesai' ? 'selected' : '' }}>selesai
                                </option>
                                <option value="dibatalkan"{{ old('status', $pesanan->status) == 'dibatalkan' ? 'selected' : '' }}>Di Batalkan
                                </option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ Route('kelola.pesanan') }}" class="btn btn-warning" style="width:100%;">Kembali</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary" style="width:100%;">Verifikasi</button>
                        </div>
                    </div>
                </div>
            </div>
    </form>
@endsection
