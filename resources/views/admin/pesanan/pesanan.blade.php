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
                            <table class="table align-items-center mb-0" id="table1">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nama User</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Kode Pesanan</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Total</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Metode Pembayaran</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Alamat Pemngiriman</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Catatan</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pesanan as $psn)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $psn->user->nama }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $psn->kode_pesanan }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                @if($psn->status == "menunggu")
                                                    <span class="badge badge-sm bg-gradient-secondary">Menunggu</span>
                                                @elseif($psn->status == "diproses")
                                                    <span class="badge badge-sm bg-gradient-info">Di Proses</span>
                                                    @elseif($psn->status == "dikirim")
                                                    <span class="badge badge-sm bg-gradient-warning">Di Kirim</span>
                                                    @elseif($psn->status == "selesai")
                                                    <span class="badge badge-sm bg-gradient-primary">Selesai</span>
                                                    @elseif($psn->status == "dibatalkan")
                                                    <span class="badge badge-sm bg-gradient-danger">Di Batalkan</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $psn->total }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ $psn->pembayaran->metode_pembayaran }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ $psn->alamat_pengiriman }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ $psn->catatan }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{ Route('edit.pesanan', $psn->id) }}"
                                                    class="btn btn-warning btn-sm"><i class="fa fa-edit"
                                                        style="font-size: 15px;"></i></a>

                                                <form action="{{ Route('hapus.pesanan.proses', $psn->id) }}" method="POST"
                                                    enctype="multipart/form-data" class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-danger btn-sm show_confirm"
                                                        data-konf-delete="{{ $psn->nama }}"><i
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
