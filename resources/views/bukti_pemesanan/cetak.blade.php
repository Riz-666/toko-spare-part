<!DOCTYPE html>
<html>

<head>
    <title>Bukti Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .page-border {
        border: 3px solid #000;
        padding: 40px;
        margin: auto;
        max-width: 800px;
        background: #fff;
        box-shadow: 0 0 15px rgba(0,0,0,0.3);
    }

    @media print {
        body {
            background: #fff !important;
        }

        .page-border {
            box-shadow: none;
            border: 2px solid #000;
            page-break-after: always;
        }
    }
</style>
</head>

<body onload="window.print()">
    <div class="page-border mt-5">
        <h1 class="text-center">LESTARI MOTOR</h1>
        <hr class="mb-7">
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
                    <th>Ongkir</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pesanan->item as $item)
                    <tr>
                        <td>{{ $item->produk->nama }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($pesanan->ongkir, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-end">
            <h5>Total: <strong>Rp {{ number_format($pesanan->total, 0, ',', '.') }}</strong></h5>
        </div>

        <div class="text-center">
            @if ($pesanan->pembayaran && $pesanan->pembayaran->bukti_bayar)
                <img src="{{ asset('storage/bukti-bayar/' . $pesanan->pembayaran->bukti_bayar) }}" style="width: 30%;">
            @else
                @if($pesanan->metode_pembayaran == 'cod')
                    Metode Pembayaran Adalah COD(Bayar Di Tempat), Silahkan Simpan Bukti Pemesanan Saja Atau Tunggu Verifikasi Dari Admin             
                @endif
            @endif
        </div>
    </div>
</body>

</html>
