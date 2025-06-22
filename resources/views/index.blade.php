@extends('layout.app')

@section('content')
    <div id="carouselExampleIndicators" class="carousel slide position-relative" data-bs-ride="carousel">
        <!-- Teks di tengah gambar -->
        <div class="carousel-caption-layer position-absolute top-50 start-50 translate-middle text-center">
            @auth
                @if (Auth::user()->role === 'customer')
                    <h1 class="text-light fw-bold text-shadow">Selamat Datang, {{ Auth::user()->nama }}</h1>
                    <p class="text-light text-shadow">Semoga Nyaman Berbelanja Di Toko Ini</p>
                @endif
            @else
                <h1 class="text-light fw-bold text-shadow">Selamat Datang di Toko Spare Part</h1>
                <p class="text-light text-shadow">Kami menyediakan berbagai suku cadang motor berkualitas</p>
            @endauth
        </div>


        <!-- Indikator -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></button>
        </div>

        <!-- Carousel Items -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://www.naikmotor.com/wp-content/uploads/2017/02/Spare_Part_Honda.jpg" class="d-block w-100"
                    alt="...">
            </div>
            <div class="carousel-item">
                <img src="https://th.bing.com/th/id/OIP.gr3iwrOIr8Rq0JPbiqaL9QHaEO?r=0&o=7rm=3&rs=1&pid=ImgDetMain&cb=idpwebp2&o=7&rm=3"
                    class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="https://th.bing.com/th/id/OIP.-CK5-wfMXvxBAFSXG9CAnwHaEK?r=0&rs=1&pid=ImgDetMain&cb=idpwebp2&o=7&rm=3"
                    class="d-block w-100" alt="...">
            </div>
        </div>

        <!-- Navigasi -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class="kategori">
        <h1>Kategori Produk</h1>
    </div>
    <div class="container">
        <div class="row text-center kategori-select">
            @foreach ($kategori as $ktg)
                <div class="col-md-3 mb-2">
                    <button class="btn btn-primary w-100" type="button" data-bs-toggle="collapse"
                        data-bs-target="#kategori-{{ $ktg->id }}" aria-expanded="false"
                        aria-controls="kategori-{{ $ktg->id }}">
                        {{ $ktg->nama }}
                    </button>
                </div>
            @endforeach
        </div>
        <div class="row mt-3" id="kategoriAccordion">
            @foreach ($kategori as $ktg)
                <div class="collapse" id="kategori-{{ $ktg->id }}" data-bs-parent="#kategoriAccordion">
                    <div class="card-collapse">
                        <div class="row">
                            @foreach ($produk->where('kategori_id', $ktg->id) as $prd)
                                <div class="col-md-3 mb-4">
                                    <div class="card h-100">
                                        <img src="{{ asset('storage/produk-img/' . $prd->gambar) }}" class="card-img-top"
                                            style="height: 180px; object-fit: cover;">
                                        <div class="card-body text-center">
                                            <h6>{{ $prd->nama }}</h6>
                                            {!! $prd->deskripsi !!}
                                            <p>Rp {{ number_format($prd->harga, 0, ',', '.') }}</p>
                                            @auth
                                                @if (auth()->user()->role === 'customer')
                                                    <div class="d-grid gap-2">
                                                        {{-- Cek PRoduk --}}
                                                        <button class="btn btn-sm btn-outline-info w-100" data-bs-toggle="modal"
                                                            data-bs-target="#lihatProdukModal-{{ $prd->id }}">
                                                            <i class="fas fa-eye"></i> Lihat Produk
                                                        </button>

                                                        {{-- Tombol Masukkan ke Keranjang --}}
                                                        <form action="{{ route('keranjang.tambah') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="produk_id" value="{{ $prd->id }}">
                                                            <button type="submit" class="btn btn-sm btn-secondary w-100">
                                                                <i class="fas fa-cart-plus"></i> Masukkan ke Keranjang
                                                            </button>
                                                        </form>
                                                        {{-- Tombol Pesan Sekarang --}}
                                                        <button class="btn btn-sm btn-primary w-100" data-bs-toggle="modal"
                                                            data-bs-target="#checkoutModal-{{ $prd->id }}">
                                                            <i class="fas fa-bolt"></i> Pesan Sekarang
                                                        </button>
                                                    </div>


                                                    {{-- Modal Checkout --}}
                                                    <form action="{{ route('checkout.proses') }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="produk_id" value="{{ $prd->id }}">
                                                        <div class="modal fade" id="checkoutModal-{{ $prd->id }}"
                                                            tabindex="-1">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Checkout Pesanan</h5>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <label>Alamat Pengiriman</label>
                                                                            <textarea name="alamat" class="form-control" required></textarea>
                                                                        </div>
                                                                        <div class="form-group mt-2">
                                                                            <label>Catatan</label>
                                                                            <textarea name="catatan" class="form-control"></textarea>
                                                                        </div>
                                                                        <div class="form-group mt-2">
                                                                            <label for="jumlah">Jumlah:</label>
                                                                            <input type="number" name="jumlah"
                                                                                class="form-control" min="1"
                                                                                value="1">
                                                                        </div>
                                                                        <div class="form-group mt-2">
                                                                            <label>Metode Pembayaran</label>
                                                                            <select name="metode_pembayaran"
                                                                                class="form-control" required>
                                                                                <option value="qris">QRIS</option>
                                                                                <option value="kartu_kredit">Kartu Kredit
                                                                                </option>
                                                                                <option value="dana">Dana</option>
                                                                                <option value="cod">COD</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-success">Pesan
                                                                            Sekarang</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>

                                                    <!-- Modal Lihat Produk -->
                                                    <div class="modal fade" id="lihatProdukModal-{{ $prd->id }}"
                                                        tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">{{ $prd->nama }}</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6 text-center">
                                                                            <img src="{{ asset('storage/produk-img/' . $prd->gambar) }}"
                                                                                class="img-fluid rounded"
                                                                                style="max-height: 300px; object-fit: cover;">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <h5 class="mb-3">Rp
                                                                                {{ number_format($prd->harga, 0, ',', '.') }}
                                                                            </h5>
                                                                            <p>{!! $prd->deskripsi !!}</p>
                                                                            <span class="badge bg-success">Terjual:
                                                                                {{ $prd->total_terjual }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Tutup</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if ($produk->where('kategori_id', $ktg->id)->isEmpty())
                            <p class="text-center text-muted">Tidak ada produk di kategori ini.</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="best-selling mt-10">
        <h1 class="text-center mb-4">Best Selling Products</h1>
    </div>
    <div class="container mt-5">
        <div class="row">
            @forelse ($bestSelling as $prd)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset('storage/produk-img/' . $prd->gambar) }}" class="card-img-top"
                            style="height: 180px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h6>{{ $prd->nama }}</h6>
                            {!! $prd->deskripsi !!}
                            <p>Rp {{ number_format($prd->harga, 0, ',', '.') }}</p>
                            <span class="badge bg-success">Terjual: {{ $prd->total_terjual }}</span>

                            @auth
                                @if (auth()->user()->role === 'customer')
                                    <div class="d-grid gap-2 mt-2">
                                        {{-- Cek PRoduk --}}
                                        <button class="btn btn-sm btn-outline-info w-100" data-bs-toggle="modal"
                                            data-bs-target="#lihatProdukBestModal-{{ $prd->id }}">
                                            <i class="fas fa-eye"></i> Lihat Produk
                                        </button>


                                        {{-- Tombol Masukkan ke Keranjang --}}
                                        <form action="{{ route('keranjang.tambah') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="produk_id" value="{{ $prd->id }}">
                                            <button type="submit" class="btn btn-sm btn-secondary w-100">
                                                <i class="fas fa-cart-plus"></i> Masukkan ke Keranjang
                                            </button>
                                        </form>

                                        {{-- Tombol Pesan Sekarang --}}
                                        <button class="btn btn-sm btn-primary w-100" data-bs-toggle="modal"
                                            data-bs-target="#checkoutBestModal-{{ $prd->id }}">
                                            <i class="fas fa-bolt"></i> Pesan Sekarang
                                        </button>
                                    </div>

                                    {{-- Modal Checkout --}}
                                    <form action="{{ route('checkout.proses') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="produk_id" value="{{ $prd->id }}">
                                        <div class="modal fade" id="checkoutBestModal-{{ $prd->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Checkout Pesanan</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Alamat Pengiriman</label>
                                                            <textarea name="alamat" class="form-control" required></textarea>
                                                        </div>
                                                        <div class="form-group mt-2">
                                                            <label>Catatan</label>
                                                            <textarea name="catatan" class="form-control"></textarea>
                                                        </div>
                                                        <div class="form-group mt-2">
                                                            <label for="jumlah">Jumlah:</label>
                                                            <input type="number" name="jumlah" class="form-control"
                                                                min="1" value="1">
                                                        </div>
                                                        <div class="form-group mt-2">
                                                            <label>Metode Pembayaran</label>
                                                            <select name="metode_pembayaran" class="form-control" required>
                                                                <option value="qris">QRIS</option>
                                                                <option value="kartu_kredit">Kartu Kredit
                                                                </option>
                                                                <option value="dana">Dana</option>
                                                                <option value="cod">COD</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">Pesan
                                                            Sekarang</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <!-- Modal Lihat Produk -->
                                    <div class="modal fade" id="lihatProdukBestModal-{{ $prd->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ $prd->nama }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6 text-center">
                                                            <img src="{{ asset('storage/produk-img/' . $prd->gambar) }}"
                                                                class="img-fluid rounded"
                                                                style="max-height: 300px; object-fit: cover;">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h5 class="mb-3">Rp
                                                                {{ number_format($prd->harga, 0, ',', '.') }}</h5>
                                                            <p>{!! $prd->deskripsi !!}</p>
                                                            <span class="badge bg-success">Terjual:
                                                                {{ $prd->total_terjual }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">Belum ada data penjualan.</p>
            @endforelse
        </div>
    </div>
@endsection
