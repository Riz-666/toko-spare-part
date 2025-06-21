<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CheckoutController;
use App\Models\Pesanan;
use App\Models\PesananItem;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    // public function proses(Request $request)
    // {
    //     $user = Auth::user();

    //     $keranjang = $user->keranjang()->with('item.produk')->first();
    //     $items = $keranjang->item;

    //     $total = $items->sum(function ($items) {
    //         return $items->produk->harga * $items->jumlah;
    //     });

    //     $pesanan = Pesanan::create([
    //         'user_id' => $user->id,
    //         'kode_pesanan' => 'ORDID-' . strtoupper(Str::random(8)),
    //         'status' => 'menunggu',
    //         'total' => $total,
    //         'metode_pembayaran' => $request->metode_pembayaran,
    //         'alamat_pengiriman' => $request->alamat,
    //         'catatan' => $request->catatan,
    //     ]);

    //     foreach ($items as $item) {
    //         PesananItem::create([
    //             'pesanan_id' => $pesanan->id,
    //             'produk_id' => $item->produk_id,
    //             'harga' => $item->produk->harga,
    //             'jumlah' => $item->jumlah,
    //             'subtotal' => $item->produk->harga * $item->jumlah,
    //         ]);
    //     }

    //     // Hapus keranjang
    //     $keranjang->item()->delete();

    //     return redirect()->route('pesanan.detail', $pesanan->id)->with('success', 'Pesanan berhasil dibuat');
    // }

    public function proses(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'jumlah' => 'required|integer|min:1',
            'alamat' => 'required|string',
            'metode_pembayaran' => 'required|in:qris,kartu_kredit,dana,cod',
        ]);

        $produk = Produk::findOrFail($request->produk_id);
        $user = Auth::user();

        $total = $produk->harga * $request->jumlah;

        $pesanan = Pesanan::create([
            'user_id' => $user->id,
            'kode_pesanan' => 'ORDID-' . strtoupper(Str::random(8)),
            'status' => 'menunggu',
            'total' => $total,
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

        // Hitung total
        $total = $keranjang->item->sum(function ($item) {
            return $item->produk->harga * $item->jumlah;
        });

        // Simpan pesanan
        $pesanan = Pesanan::create([
            'user_id' => $user->id,
            'kode_pesanan' => 'ORDID-' . strtoupper(Str::random(8)),
            'status' => 'menunggu',
            'total' => $total,
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

        // Kosongkan keranjang
        $keranjang->item()->delete();

        return redirect()->route('pesanan.detail', $pesanan->id)->with('success', 'Pesanan berhasil dibuat dari keranjang');
    }
}
