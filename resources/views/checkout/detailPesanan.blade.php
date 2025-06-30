@extends('layout.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Detail Pesanan</h4>
            </div>
            <div class="card-body">
                <p><strong>Kode Pesanan:</strong> {{ $pesanan->kode_pesanan }}</p>
                <p><strong>Status:</strong> <span class="badge bg-warning text-dark">{{ ucfirst($pesanan->status) }}</span>
                </p>
                <p><strong>Harga:</strong> Rp {{ number_format($pesanan->item->first()->harga, 0, ',', '.') }}</p>
                <p><strong>Ongkir:</strong> Rp {{ number_format($pesanan->ongkir, 0, ',', '.') }}</p>
                <p><strong>Total Bayar:</strong> <span class="text-success fw-bold">Rp
                        {{ number_format($pesanan->total, 0, ',', '.') }}</span></p>
                <p><strong>Alamat Pengiriman:</strong> {{ $pesanan->alamat_pengiriman }}</p>
                <p><strong>Catatan:</strong> {{ $pesanan->catatan ?? '-' }}</p>
                <p><strong>Metode Pembayaran:</strong> <span class="text-uppercase">{{ $pesanan->metode_pembayaran }}</span>
                </p>

                {{-- Tambahan info sesuai metode --}}
                @if ($pesanan->metode_pembayaran === 'qris')
                    <div class="mt-3 text-center">
                        <img src="{{ asset('storage/default-img/qrcode.jpg') }}" alt="QRIS" width="250">
                        <p class="text-muted mt-2">Silakan scan kode QR untuk menyelesaikan pembayaran.</p>
                    </div>
                @elseif ($pesanan->metode_pembayaran === 'kartu_kredit')
                    <div class="mt-3">
                        <p><strong>No Rekening Admin:</strong> 1234 5678 9000 a/n Toko Sparepart</p>
                        <p class="text-muted">Silakan transfer ke rekening di atas dan upload bukti pembayaran.</p>
                    </div>
                @elseif ($pesanan->metode_pembayaran === 'dana')
                    <div class="mt-3">
                        <p><strong>No Dana Admin:</strong> 0812 3456 7890</p>
                        <p class="text-muted">Silakan kirim pembayaran ke nomor Dana tersebut lalu upload bukti bayar.</p>
                    </div>
                @endif
            </div>

        </div>

        <div class="card shadow mt-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Upload Bukti Pembayaran</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pesanan.uploadBukti', $pesanan->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Bukti Pembayaran (gambar)</label>
                        <input type="file" name="bukti_bayar" class="form-control" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Bayar Sekarang</button>
                </form>
            </div>
        </div>
    </div>
@endsection
