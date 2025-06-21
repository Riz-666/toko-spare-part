@extends('admin.layout.app')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>{{ $judul }}</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>

                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Kode Pesanan</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Metode Pembayaran</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Tanggal Bayar</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pembayaran as $byr)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="{{ asset('/storage/bukti-bayar/' . $byr->bukti_bayar) }}"
                                                            class="avatar avatar-sm me-3" alt="user1">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $byr->pesanan->kode_pesanan }}</h6>
                                                        <p class="text-xs font-weight-bold mb-0">ID Pesanan :
                                                            {{ $byr->pesanan_id }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $byr->metode_pembayaran }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                @if ($byr->status == 'belum bayar')
                                                    <span class="badge badge-sm bg-gradient-secondary">Belum Bayar</span>
                                                @elseif($byr->status == 'menunggu verifikasi')
                                                    <span class="badge badge-sm bg-gradient-info">Menunggu Verifikasi</span>
                                                @elseif($byr->status == 'berhasil')
                                                    <span class="badge badge-sm bg-gradient-success">Berhasil</span>
                                                @elseif($byr->status == 'gagal')
                                                    <span class="badge badge-sm bg-gradient-danger">Gagal</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $byr->tanggal_bayar }}</p>
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{ Route('edit.pembayaran', $byr->id) }}"
                                                    class="btn btn-warning btn-sm"><i class="fa fa-edit"
                                                        style="font-size: 15px;"></i></a>

                                                <form action="{{ Route('hapus.pembayaran.proses', $byr->id) }}"
                                                    method="POST" enctype="multipart/form-data" class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-danger btn-sm show_confirm"
                                                        data-konf-delete="{{ $byr->nama }}"><i
                                                            class="fa fa-trash show_confirm"
                                                            style="font-size: 15px;"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
