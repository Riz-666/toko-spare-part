@extends('layout.app')
@section('content')
    <!-- Carousel -->
    <div id="carouselExampleIndicators" class="carousel slide position-relative" data-bs-ride="carousel">
        <div class="carousel-caption-layer position-absolute top-50 start-50 translate-middle text-center">
            @auth
                @if (Auth::user()->role === 'customer')
                    <h1 class="text-light fw-bold text-shadow">Selamat Datang, {{ Auth::user()->nama }}</h1>
                    <p class="text-light text-shadow">Semoga Nyaman Berbelanja Di Toko Ini</p>
                @endif
            @else
                <h1 class="text-light fw-bold text-shadow">Selamat Datang di Lestari Motor</h1>
                <p class="text-light text-shadow">Kami menyediakan berbagai suku cadang Mobil berkualitas</p>
            @endauth
        </div>

        <!-- Indikator -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></button>
        </div>

        <!-- Gambar Carousel -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('storage/default-img/carousel1.jpg') }}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('storage/default-img/carousel2.jpg') }}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('storage/default-img/carousel3.jpg') }}" class="d-block w-100" alt="...">
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

    <!-- Kategori Produk -->
    <div class="kategori">
        <h1>Kategori Produk</h1>
    </div>

    <!-- Daftar Kategori & Produk -->
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
                                    <div class="card h-100 d-flex flex-column">
                                        <img src="{{ asset('storage/produk-img/' . $prd->gambar) }}" class="card-img-top"
                                            style="height: 180px; object-fit: cover;">
                                        <div class="card-body text-center">
                                            <h6>{{ $prd->nama }}</h6>
                                            <div class="description-container" style="max-height: 100px; overflow-y: auto;">
                                                {!! $prd->deskripsi !!}
                                            </div>
                                            <p><span class="badge bg-success"><i class="fa fa-tag"></i>
                                                    Rp {{ number_format($prd->harga, 0, ',', '.') }}
                                                </span></p>
                                        </div>
                                        <div class="card-footer bg-white border-0 d-grid gap-2 px-2 pt-0">
                                            {{-- Detail Produk --}}
                                            <button class="btn btn-sm btn-outline-info w-100" data-bs-toggle="modal"
                                                data-bs-target="#lihatProdukModal-{{ $prd->id }}">
                                                <i class="fas fa-eye"></i> Lihat Produk
                                            </button>

                                            {{-- Masukkan ke Keranjang --}}
                                            @auth
                                                <form action="{{ route('keranjang.tambah') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="produk_id" value="{{ $prd->id }}">
                                                    <button type="submit" class="btn btn-sm btn-secondary w-100">
                                                        <i class="fas fa-cart-plus"></i> Masukkan ke Keranjang
                                                    </button>
                                                </form>
                                            @else
                                                <button type="button" class="btn btn-sm btn-secondary w-100"
                                                    onclick="showLoginAlert()">
                                                    <i class="fas fa-cart-plus"></i> Masukkan ke Keranjang
                                                </button>
                                            @endauth

                                            {{-- Pesan Sekarang --}}
                                            @auth
                                                <button class="btn btn-sm btn-primary w-100" data-bs-toggle="modal"
                                                    data-bs-target="#checkoutModal-{{ $prd->id }}">
                                                    <i class="fas fa-bolt"></i> Pesan Sekarang
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-sm btn-primary w-100"
                                                    onclick="showLoginAlert()">
                                                    <i class="fas fa-bolt"></i> Pesan Sekarang
                                                </button>
                                            @endauth
                                        </div>
                                    </div>

                                    <!-- Modal Detail Produk -->
                                    <div class="modal fade" id="lihatProdukModal-{{ $prd->id }}" tabindex="-1">
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
                                                            <span class="badge bg-secondary">Stok:
                                                                {{ $prd->stok }}</span><br>
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

                                    {{-- Modal Checkout --}}
                                    @auth
                                        <form action="{{ route('checkout.proses') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="produk_id" value="{{ $prd->id }}">
                                            <div class="modal fade" id="checkoutModal-{{ $prd->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Checkout Pesanan</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label>Alamat Pengiriman</label>
                                                                <textarea name="alamat" class="form-control" required>{{ Auth::user()->alamat }}</textarea>
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
                                                                <select name="metode_pembayaran" class="form-control"
                                                                    required>
                                                                    <option value="qris">QRIS</option>
                                                                    <option value="kartu_kredit">Kartu Kredit</option>
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
                                    @endauth
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

    <!-- Best Selling Products -->
    <div class="best-selling mt-10">
        <h1 class="text-center mb-4">Best Selling Products</h1>
    </div>
    <div class="container mt-5">
        <div class="row">
            @forelse ($bestSelling as $prd)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 d-flex flex-column">
                        <img src="{{ asset('storage/produk-img/' . $prd->gambar) }}" class="card-img-top"
                            style="height: 180px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h6>{{ $prd->nama }}</h6>
                            <div class="description-container" style="max-height: 100px; overflow-y: auto;">
                                {!! $prd->deskripsi !!}
                            </div>
                            <p>Rp {{ number_format($prd->harga, 0, ',', '.') }}</p>
                            <span class="badge bg-success">Terjual: {{ $prd->total_terjual }}</span>
                        </div>
                        <div class="card-footer bg-white border-0 d-grid gap-2 px-2 pt-0">
                            {{-- Detail Produk --}}
                            <button class="btn btn-sm btn-outline-info w-100" data-bs-toggle="modal"
                                data-bs-target="#lihatProdukBestModal-{{ $prd->id }}">
                                <i class="fas fa-eye"></i> Lihat Produk
                            </button>

                            {{-- Masukkan ke Keranjang --}}
                            @auth
                                <form action="{{ route('keranjang.tambah') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $prd->id }}">
                                    <button type="submit" class="btn btn-sm btn-secondary w-100">
                                        <i class="fas fa-cart-plus"></i> Masukkan ke Keranjang
                                    </button>
                                </form>
                            @else
                                <button type="button" class="btn btn-sm btn-secondary w-100" onclick="showLoginAlert()">
                                    <i class="fas fa-cart-plus"></i> Masukkan ke Keranjang
                                </button>
                            @endauth

                            {{-- Pesan Sekarang --}}
                            @auth
                                <button class="btn btn-sm btn-primary w-100" data-bs-toggle="modal"
                                    data-bs-target="#checkoutBestModal-{{ $prd->id }}">
                                    <i class="fas fa-bolt"></i> Pesan Sekarang
                                </button>
                            @else
                                <button type="button" class="btn btn-sm btn-primary w-100" onclick="showLoginAlert()">
                                    <i class="fas fa-bolt"></i> Pesan Sekarang
                                </button>
                            @endauth
                        </div>
                    </div>

                    <!-- Modal Detail Produk Best Selling -->
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
                                                class="img-fluid rounded" style="max-height: 300px; object-fit: cover;">
                                        </div>
                                        <div class="col-md-6">
                                            <h5 class="mb-3">Rp
                                                {{ number_format($prd->harga, 0, ',', '.') }}</h5>
                                            <p>{!! $prd->deskripsi !!}</p>
                                            <span class="badge bg-secondary">Stok: {{ $prd->stok }}</span><br>
                                            <span class="badge bg-success">Terjual: {{ $prd->total_terjual }}</span>
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

                    {{-- Modal Checkout Best Selling --}}
                    @auth
                        <form action="{{ route('checkout.proses') }}" method="POST" enctype="multipart/form-data">
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
                                                <textarea name="alamat" class="form-control" required>{{ Auth::user()->alamat }}</textarea>
                                            </div>
                                            <div class="form-group mt-2">
                                                <label>Catatan</label>
                                                <textarea name="catatan" class="form-control"></textarea>
                                            </div>
                                            <div class="form-group mt-2">
                                                <label>Jumlah:</label>
                                                <input type="number" name="jumlah" class="form-control" min="1"
                                                    value="1">
                                            </div>
                                            <div class="form-group mt-2">
                                                <label>Metode Pembayaran</label>
                                                <select name="metode_pembayaran" class="form-control" required>
                                                    <option value="qris">QRIS</option>
                                                    <option value="kartu_kredit">Kartu Kredit</option>
                                                    <option value="dana">Dana</option>
                                                    <option value="cod">COD</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Pesan Sekarang</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endauth
                </div>
            @empty
                <p class="text-center text-muted">Belum ada data penjualan.</p>
            @endforelse
        </div>
    </div>

    <!-- Live Chat Button -->
    @auth
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Buat tombol chat
                const button = document.createElement("a");

                const chatUrl = @json(auth()->user()->hasRole('admin') ? route('admin.chat.list') : route('customer.chat.index', 1));

                button.href = chatUrl;
                button.title = "Live Chat";
                button.innerHTML = `<i class="fas fa-comments fa-lg"></i>`;

                Object.assign(button.style, {
                    position: 'fixed',
                    right: '20px',
                    bottom: '20px',
                    width: '60px',
                    height: '60px',
                    backgroundColor: '#28a745',
                    color: '#fff',
                    borderRadius: '50%',
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                    fontSize: '22px',
                    zIndex: '999999',
                    boxShadow: '0 5px 15px rgba(0,0,0,0.3)',
                    textDecoration: 'none',
                    cursor: 'pointer'
                });

                document.body.appendChild(button);

                // ===== Bubble Alert bergaya chat =====
                const bubbleWrapper = document.createElement("div");
                bubbleWrapper.style.position = 'fixed';
                bubbleWrapper.style.right = '90px';
                bubbleWrapper.style.bottom = '95px'; // Di atas tombol chat
                bubbleWrapper.style.zIndex = '1000000';
                bubbleWrapper.style.opacity = '0';
                bubbleWrapper.style.transition = 'opacity 0.4s ease';

                const reminder = document.createElement("div");
                reminder.textContent = "Butuh bantuan? Chat admin sekarang!";

                Object.assign(reminder.style, {
                    backgroundColor: '#ffc107',
                    color: '#000',
                    padding: '10px 14px',
                    borderRadius: '16px',
                    maxWidth: '220px',
                    boxShadow: '0 4px 10px rgba(0,0,0,0.2)',
                    fontSize: '14px',
                    position: 'relative',
                });

                // Tambahkan panah di bawah bubble
                const arrow = document.createElement("div");
                Object.assign(arrow.style, {
                    position: 'absolute',
                    bottom: '-10px',
                    right: '20px',
                    width: '0',
                    height: '0',
                    borderLeft: '10px solid transparent',
                    borderRight: '10px solid transparent',
                    borderTop: '10px solid #ffc107',
                });

                reminder.appendChild(arrow);
                bubbleWrapper.appendChild(reminder);
                document.body.appendChild(bubbleWrapper);

                // Fungsi tampil dan sembunyikan alert
                function showReminder() {
                    bubbleWrapper.style.opacity = '1';
                    setTimeout(() => {
                        bubbleWrapper.style.opacity = '0';
                    }, 4000); // tampil 4 detik
                }

                // Muncul pertama kali setelah 3 detik
                setTimeout(showReminder, 3000);
                // Lalu setiap 10 detik
                setInterval(showReminder, 10000);
            });
        </script>


    @endauth

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2 @11"></script>
    <script>
        function showLoginAlert() {
            Swal.fire({
                icon: 'warning',
                title: 'Harus Login Terlebih Dahulu!',
                text: 'Silakan login untuk melanjutkan.',
                showCancelButton: true,
                confirmButtonText: 'Ke Halaman Login',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('login') }}";
                }
            });
        }
    </script>
@endsection
