@extends('layout.app')
@section('content')
    <div class="container">
        <div>
            <h3>Daftar Keranjang</h3>
        </div>

        @php $grandTotal = 0; @endphp

        @forelse ($keranjang->item as $item)
            @php
                $subtotal = $item->produk->harga * $item->jumlah;
                $grandTotal += $subtotal;
            @endphp

            <div class="card mb-3 mt-3">
                <div class="row g-0 align-items-center">
                    <div class="col-md-4">
                        <img src="{{ asset('storage/produk-img/' . $item->produk->gambar) }}" class="img-fluid rounded-start"
                            alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><strong>{{ $item->produk->nama }}</strong></h5>
                            <p class="card-text">Harga: Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</p>

                            <form action="{{ route('keranjang.update', $item->id) }}" method="POST"
                                class="d-flex align-items-center gap-2">
                                @csrf
                                <label>Jumlah: </label>
                                <input type="number" name="jumlah" value="{{ $item->jumlah }}" min="1"
                                    class="form-control" style="width: 70px;">
                                <button type="submit" class="btn btn-sm btn-success">Update</button>
                            </form>

                            <p class="mt-2">Subtotal: Rp {{ number_format($subtotal, 0, ',', '.') }}</p>

                            <!-- Tombol Aksi -->
                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <!-- Tombol Checkout (Modal nanti) -->
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checkoutModal">
                                    Checkout
                                </button>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('keranjang.hapus', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus item ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info mt-4">
                Keranjang Anda masih kosong.
            </div>
        @endforelse

        {{-- Total hanya ditampilkan jika ada isi --}}
        @if ($keranjang->item->count())
            <div class="text-end mt-4">
                <h4>Total Seluruh: <strong>Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong></h4>
            </div>
        @endif
    </div>


    <!-- Modal -->
    <form action="{{ route('keranjang.checkout') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="checkoutModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Checkout Pesanan</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Alamat Pengiriman</label>
                            <textarea name="alamat" class="form-control">{{ Auth::user()->alamat }}</textarea>
                        </div>
                        <div class="form-group mt-2">
                            <label>Catatan</label>
                            <textarea name="catatan" class="form-control"></textarea>
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
@endsection
