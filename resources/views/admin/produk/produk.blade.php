@extends('admin.layout.app')
@section('content')

<style>
    
</style>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>{{ $judul }}</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <a href="{{ Route('add.produk') }}" class="btn btn-primary" style="margin-left: 10px"><i class="fa fa-plus"></i> Tambah Produk</a>
                            <table class="table align-items-center mb-0" id="table1">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kategori</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Produk</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Deskripsi</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stok</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Harga</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($produk as $prdk)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="{{ asset('/storage/produk-img/'.$prdk->gambar) }}" class="avatar avatar-sm me-3" alt="user1">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $prdk->kategori->nama }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $prdk->nama }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm" style="max-width: 250px; max-height: 80px; overflow-y: auto;">
                                                <span title="{!! strip_tags($prdk->deskripsi) !!}" data-bs-toggle="tooltip" data-bs-placement="top" style="display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 200px;">
                                                    {!! Str::limit(strip_tags($prdk->deskripsi), 100) !!}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $prdk->stok }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">{{ $prdk->harga }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{ Route('edit.produk',$prdk->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit" style="font-size: 15px;"></i></a>

                                                <form action="{{ Route('hapus.produk.proses',$prdk->id) }}" method="POST" enctype="multipart/form-data" class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-danger btn-sm show_confirm" data-konf-delete="{{ $prdk->nama }}"><i class="fa fa-trash show_confirm" style="font-size: 15px;"></i></button>
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
    </div>
    @push('scripts')
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
@endsection