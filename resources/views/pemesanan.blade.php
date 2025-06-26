@extends('layout.app')
@section('content')

    <div class="container mt-4">
        <h3 class="mb-4">Pesanan Anda</h3>

        @if ($items->isEmpty())
            <div class="alert alert-info text-center">
                Anda belum memesan apapun.
            </div>
        @else
            @foreach ($items->chunk(3) as $chunk)
                <div class="row">
                    @foreach ($chunk as $item)
                        @php
                            $status = $item->pesanan->status;
                            $statusClass = match ($status) {
                                'menunggu' => 'secondary',
                                'diproses' => 'info',
                                'dikirim' => 'warning',
                                'selesai' => 'success',
                                'dibatalkan' => 'danger',
                                default => 'light',
                            };
                        @endphp

                        <div class="col-md-4 mb-4">
                            <div class="card border border-{{ $statusClass }}">
                                <img src="{{ asset('storage/produk-img/' . $item->produk->gambar) }}" class="card-img-top"
                                    style="height: 180px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->produk->nama }}</h5>
                                    <p class="card-text">Jumlah: {{ $item->jumlah }}</p>
                                    <p class="card-text">Harga: Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                    <p class="card-text"><strong>Total:</strong> Rp
                                        {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                    <span class="badge bg-{{ $statusClass }}">{{ ucfirst($status) }}</span>
                                    <p class="mt-4 text-secondary">Pesanan: {{ $item->pesanan->kode_pesanan }}</p>
                                    <a href="{{ route('pesanan.cetak', $item->pesanan->id) }}" target="_blank"
                                        class="btn btn-sm btn-outline-dark mt-3 w-100">
                                        <i class="fas fa-print"></i> Cetak Bukti Pemesanan
                                    </a>
                                    <form action="{{ route('pesanan.hapus', $item->pesanan->id) }}" method="POST" class="mt-2">
                                        @csrf
                                        @method('DELETE')
                                        @if($item->pesanan->status == 'menunggu')
                                        <button class="btn btn-sm btn-danger show_confirm w-100" data-konf-delete="{{ $item->produk->nama }}" ><i class="fas fa-xmark show_confirm"></i> Batalkan
                                            Pesanan</button>
                                        @else
                                            <button class="btn btn-sm btn-secondary w-100" disabled><i class="fas fa-xmark show_confirm"></i> Batalkan Pesanan</button>
                                        @endif
                                    </form>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>


@endsection
