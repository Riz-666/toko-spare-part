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
                            <a href="{{ Route('add.user') }}" class="btn btn-primary" style="margin-left: 10px"><i class="fa fa-plus"></i> Tambah User</a>
                            <table class="table align-items-center mb-0" id="table1">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nama/Email</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Role</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Telpon</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Alamat</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user as $usr)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="{{ asset('/storage/user-img/'.$usr->foto) }}" class="avatar avatar-sm me-3" alt="user1">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $usr->nama }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $usr->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($usr->role == "admin")
                                                    <span class="badge badge-sm bg-gradient-success">Admin</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-primary">Customer</span>
                                                @endif

                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $usr->telepon }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">{{ $usr->alamat }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{ Route('edit.user',$usr->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit" style="font-size: 15px;"></i></a>

                                                <form action="{{ Route('hapus.user.proses',$usr->id) }}" method="POST" enctype="multipart/form-data" class="d-inline">
                                                    @csrf
                                                 <button class="btn btn-danger btn-sm show_confirm" data-konf-delete="{{ $usr->nama }}"><i class="fa fa-trash show_confirm" style="font-size: 15px;"></i></button>
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
