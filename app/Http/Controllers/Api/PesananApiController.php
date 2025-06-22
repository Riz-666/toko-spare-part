<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\PesananItem;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PesananApiController extends Controller
{
    // Tampilkan semua pesanan user yang login
    public function index()
    {
        $user = Auth::user();
        $pesanan = Pesanan::with('item.produk')->where('user_id', $user->id)->get();
        return response()->json($pesanan);
    }

    // Simpan pesanan baru (checkout dari keranjang)
    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'alamat_pengiriman' => 'required',
            'catatan' => 'nullable',
            'metode_pembayaran' => 'required|in:qris,kartu_kredit,dana,cod',
        ]);

        $keranjang = $user->keranjang()->with('item.produk')->first();

        if (!$keranjang || $keranjang->item->count() == 0) {
            return response()->json(['message' => 'Keranjang kosong'], 400);
        }

        $total = 0;
        foreach ($keranjang->item as $item) {
            $total += $item->produk->harga * $item->jumlah;
        }

        // Simpan pesanan
        $pesanan = Pesanan::create([
            'user_id' => $user->id,
            'kode_pesanan' => 'PSN-' . strtoupper(Str::random(6)),
            'metode_pembayaran' => $request->metode_pembayaran,
            'status' => 'menunggu',
            'total' => $total,
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'catatan' => $request->catatan
        ]);

        // Simpan item
        foreach ($keranjang->item as $item) {
            PesananItem::create([
                'pesanan_id' => $pesanan->id,
                'produk_id' => $item->produk_id,
                'jumlah' => $item->jumlah,
                'harga' => $item->produk->harga
            ]);
        }

        // Kosongkan keranjang
        $keranjang->item()->delete();

        return response()->json(['message' => 'Pesanan berhasil dibuat', 'pesanan' => $pesanan], 201);
    }

    // Tampilkan detail satu pesanan
    public function show($id)
    {
        $pesanan = Pesanan::with('item.produk')->where('id', $id)->where('user_id', Auth::id())->first();

        if (!$pesanan) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }

        return response()->json($pesanan);
    }
}
