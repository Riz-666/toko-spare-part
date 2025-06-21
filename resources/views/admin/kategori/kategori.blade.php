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
                            <a href="{{ Route('add.kategori') }}" class="btn btn-primary" style="margin-left: 10px"><i class="fa fa-plus"></i> Tambah Kategori</a>
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No.</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nama Kategori</th>

                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kategori as $ktg)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $loop->iteration }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $ktg->nama }}</p>
                                            </td>
                                            <td class="align-middle text-end">
                                                <a href="{{ Route('edit.kategori',$ktg->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit" style="font-size: 15px;"></i></a>

                                                <form action="{{ Route('hapus.kategori.proses',$ktg->id) }}" method="POST" enctype="multipart/form-data" class="d-inline">
                                                    @csrf
                                                 <button class="btn btn-danger btn-sm show_confirm" data-konf-delete="{{ $ktg->nama }}"><i class="fa fa-trash show_confirm" style="font-size: 15px;"></i></button>
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
