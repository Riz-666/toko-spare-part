<!DOCTYPE html>
<html>
<head>
    <title>Bukti Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body onload="window.print()">
    <div class="container mt-5">
        <h3 class="text-center mb-4">Bukti Pemesanan</h3>
        <p><strong>Kode Pesanan:</strong> {{ $pesanan->kode_pesanan }}</p>
        <p><strong>Status:</strong> {{ ucfirst($pesanan->status) }}</p>
        <p><strong>Alamat Pengiriman:</strong> {{ $pesanan->alamat_pengiriman }}</p>
        <p><strong>Metode Pembayaran:</strong> {{ strtoupper($pesanan->metode_pembayaran) }}</p>
        <hr>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pesanan->item as $item)
                    <tr>
                        <td>{{ $item->produk->nama }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-end">
            <h5>Total: <strong>Rp {{ number_format($pesanan->total, 0, ',', '.') }}</strong></h5>
        </div>

        <div class="text-center">
            <img src="{{ asset('storage/bukti-bayar/'.$pesanan->pembayaran->bukti_bayar) }}" style="width: 70%;">
        </div>
    </div>
</body>
</html>
