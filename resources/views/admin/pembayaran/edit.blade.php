@extends('admin.layout.app')
@section('content')
    <form action="{{ Route('edit.pembayaran.proses', $pembayaran->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">{{ $judul }}</h5>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="nama">Kode Pesanan</label><br>
                            <input type="text" class="form-control" name="user_id" disabled
                                value="{{ $pembayaran->pesanan->kode_pesanan }}">
                        </div>
                        <div class="col-md-4">
                            <label for="nama">Metode Pembayaran</label><br>
                            <input type="text" class="form-control" name="metode_pembayaran" disabled
                                value="{{ $pembayaran->metode_pembayaran }}">
                        </div>
                        <div class="col-md-4">
                            <label for="nama">Tanggal Bayar</label><br>
                            <input type="text" class="form-control" name="total" disabled
                                value="{{ $pembayaran->tanggal_bayar }}">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="nama">Status</label><br>
                            <select name="status" id="" class="form-control">
                                <option
                                    value="belum bayar"{{ old('status', $pembayaran->status) == 'belum bayar' ? 'selected' : '' }}>
                                    Belum Bayar
                                </option>
                                <option value="menunggu verifikasi"
                                    {{ old('status', $pembayaran->status) == 'menunggu verifikasi' ? 'selected' : '' }}>
                                    Menunggu Verifikasi</option>
                                <option
                                    value="berhasil"{{ old('status', $pembayaran->status) == 'berhasil' ? 'selected' : '' }}>
                                    Berhasil
                                </option>
                                <option value="gagal"{{ old('status', $pembayaran->status) == 'gagal' ? 'selected' : '' }}>
                                    Gagal
                                </option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row text-center">
                        <div class="col">
                            @if ($pembayaran->bukti_bayar)
                                <img src="{{ asset('storage/bukti-bayar/' . $pembayaran->bukti_bayar) }}" class="foto-preview"
                                    width="50%">
                                <p></p>
                            @else
                                <p>Belum Menyertakan Bukti Pembayaran</p>
                            @endif
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ Route('kelola.pembayaran') }}" class="btn btn-warning"
                                style="width:100%;">Kembali</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary" style="width:100%;">Verifikasi</button>
                        </div>
                    </div>
                </div>
            </div>
    </form>
@endsection
