<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CheckoutController;
use App\Models\KeranjangItem;
use App\Models\Pesanan;
use App\Models\PesananItem;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class CheckoutController extends Controller
{
    public function proses(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'jumlah' => 'required|integer|min:1',
            'alamat' => 'required|string',
            'metode_pembayaran' => 'required|in:qris,kartu_kredit,dana,cod',
        ]);

        $produk = Produk::findOrFail($request->produk_id);
        if ($produk->stok < $request->jumlah) {
            return back()->with('error', 'Stok produk tidak mencukupi');
        }
        $user = Auth::user();

        $total = $produk->harga * $request->jumlah;
        $ongkir = 10000;
        
        // Simpan pesanan
        $pesanan = Pesanan::create([
            'user_id' => $user->id,
            'kode_pesanan' => 'ORDID-' . strtoupper(Str::random(8)),
            'status' => 'menunggu',
            'total' => $total + $ongkir,
            'ongkir' => $ongkir,
            'metode_pembayaran' => $request->metode_pembayaran,
            'alamat_pengiriman' => $request->alamat,
            'catatan' => $request->catatan,
        ]);

        PesananItem::create([
            'pesanan_id' => $pesanan->id,
            'produk_id' => $produk->id,
            'harga' => $produk->harga,
            'jumlah' => $request->jumlah,
            'subtotal' => $total,
        ]);

        $produk->decrement('stok', $request->jumlah);

        Cache::put('last_pesanan_baru_admin', $pesanan->id, now()->addMinutes(10));
        
        return redirect()->route('pesanan.detail', $pesanan->id)->with('success', 'Pesanan berhasil dibuat');
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
        ]);

        $user = Auth::user();

        // Ambil atau buat keranjang
        $keranjang = $user->keranjang ?? Keranjang::create(['user_id' => $user->id]);

        // Cek apakah produk sudah ada di keranjang
        $item = $keranjang->item()->where('produk_id', $request->produk_id)->first();

        if ($item) {
            $item->jumlah += 1;
            $item->save();
        } else {
            $keranjang->item()->create([
                'produk_id' => $request->produk_id,
                'jumlah' => 1,
            ]);
        }

        return back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function checkoutDariKeranjang(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string',
            'metode_pembayaran' => 'required|in:qris,kartu_kredit,dana,cod',
        ]);

        $user = Auth::user();

        // Ambil keranjang beserta item dan produk
        $keranjang = $user->keranjang()->with('item.produk')->first();

        if (!$keranjang || $keranjang->item->isEmpty()) {
            return back()->with('error', 'Keranjang kosong');
        }

        // Hitung total harga barang
        $total = $keranjang->item->sum(function ($item) {
            return $item->produk->harga * $item->jumlah;
        });

        // Hitung total jumlah item untuk ongkir
        $totalJumlahItem = $keranjang->item->sum('jumlah');
        $ongkir = 10000 * $totalJumlahItem;
        
        // Simpan pesanan
        $pesanan = Pesanan::create([
            'user_id' => $user->id,
            'kode_pesanan' => 'ORDID-' . strtoupper(Str::random(8)),
            'status' => 'menunggu',
            'total' => $total + $ongkir,
            'ongkir' => $ongkir,
            'metode_pembayaran' => $request->metode_pembayaran,
            'alamat_pengiriman' => $request->alamat,
            'catatan' => $request->catatan,
        ]);

        // Simpan item pesanan
        foreach ($keranjang->item as $item) {
            PesananItem::create([
                'pesanan_id' => $pesanan->id,
                'produk_id' => $item->produk_id,
                'harga' => $item->produk->harga,
                'jumlah' => $item->jumlah,
                'subtotal' => $item->produk->harga * $item->jumlah,
            ]);
        }
        $item->produk->decrement('stok', $item->jumlah);
        // Kosongkan keranjang
        $keranjang->item()->delete();
        Cache::put('last_pesanan_baru_admin', $pesanan->id, now()->addMinutes(10));

        return redirect()->route('pesanan.detail', $pesanan->id)->with('success', 'Pesanan berhasil dibuat dari keranjang');
    }

    public function checkoutSatuan(Request $request, $itemId)
    {
        $request->validate([
            'alamat' => 'required|string',
            'metode_pembayaran' => 'required|in:qris,kartu_kredit,dana,cod',
        ]);

        $user = Auth::user();

        $item = KeranjangItem::with('produk', 'keranjang')
            ->where('id', $itemId)
            ->whereHas('keranjang', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->firstOrFail();

        // Simpan pesanan
        $pesanan = Pesanan::create([
            'user_id' => $user->id,
            'kode_pesanan' => 'ORDID-' . strtoupper(Str::random(8)),
            'status' => 'menunggu',
            'total' => $item->produk->harga * $item->jumlah,
            'metode_pembayaran' => $request->metode_pembayaran,
            'alamat_pengiriman' => $request->alamat,
            'catatan' => $request->catatan,
        ]);

        // Simpan item pesanan
        PesananItem::create([
            'pesanan_id' => $pesanan->id,
            'produk_id' => $item->produk_id,
            'harga' => $item->produk->harga,
            'jumlah' => $item->jumlah,
            'subtotal' => $item->produk->harga * $item->jumlah,
        ]);
        $item->produk->decrement('stok', $item->jumlah);
        // Hapus item dari keranjang
        $item->delete();
        Cache::put('last_pesanan_baru_admin', $pesanan->id, now()->addMinutes(10));

        return redirect()->route('pesanan.detail', $pesanan->id)->with('success', 'Checkout berhasil untuk 1 produk');
    }
}
