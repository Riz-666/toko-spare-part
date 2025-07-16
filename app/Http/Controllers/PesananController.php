<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\PesananItem;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with(['user', 'pembayaran'])->get();
        return view('admin.pesanan.pesanan', [
            'judul' => 'Kelola Pesanan',
            'pesanan' => $pesanan,
        ]);
    }

    public function edit(string $id)
    {
        $pesanan = Pesanan::with(['user', 'pembayaran'])->findOrFail($id);

        return view('admin.pesanan.edit', [
            'judul' => 'Verifikasi Pesanan',
            'pesanan' => $pesanan,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $rules = [
            'status' => 'required',
        ];

        $validatedData = $request->validate($rules);

        $pesanan->status = $request->status;
        $pesanan->save();

        // notif untuk user
        Cache::put('last_verified_pesanan_id_user_' . $pesanan->user_id, $pesanan->id, now()->addMinutes(10));

        return redirect()->route('kelola.pesanan')->with('success', 'Berhasil Memperbarui Status');
    }

    public function destroy(string $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->delete();

        return redirect()->route('kelola.pesanan')->with('success');
    }

    public function buat(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $user = Auth::user();

        // Ambil data produk
        $produk = Produk::findOrFail($request->produk_id);
        $harga = $produk->harga;
        $jumlah = $request->jumlah;
        $subtotal = $harga * $jumlah;

        // Buat pesanan
        $pesanan = Pesanan::create([
            'user_id' => $user->id,
            'kode_pesanan' => 'ORDERID-' . strtoupper(Str::random(8)),
            'status' => 'menunggu',
            'total' => $subtotal,
            'alamat_pengiriman' => 'Alamat default', // bisa diganti nanti
            'catatan' => null,
        ]);

        // Buat item pesanan
        PesananItem::create([
            'pesanan_id' => $pesanan->id,
            'produk_id' => $produk->id,
            'harga' => $harga,
            'jumlah' => $jumlah,
            'subtotal' => $subtotal,
        ]);

        // Setelah pesanan berhasil dibuat
        Cache::put('notif_pesanan_baru', $pesanan->id, now()->addMinutes(10));

        return back()->with('success', 'Pesanan berhasil dibuat!');
    }

    public function detail($id)
    {
        $pesanan = Pesanan::with(['user', 'item.produk'])->findOrFail($id);

        // Validasi: hanya pemilik pesanan yang bisa lihat
        if (!auth()->user()->is($pesanan->user)) {
            abort(403, 'Tidak diizinkan mengakses pesanan ini.');
        }
        return view('checkout.detailPesanan', [
            'judul' => 'Detail Pesanan',
            'pesanan' => $pesanan,
        ]);
    }

    public function checkNew_fromCustomer()
    {
        $lastId = Cache::get('last_pesanan_baru_admin');

        if ($lastId) {
            // Hapus cache supaya hanya muncul sekali
            Cache::forget('last_pesanan_baru_admin');

            return response()->json([
                'new' => true,
                'pesanan_id' => $lastId,
            ]);
        }

        return response()->json(['new' => false]);
    }

    public function checkNew_customer()
    {
        $userId = auth()->id();
        $lastVerifiedId = Cache::get('last_verified_pesanan_id_user_' . $userId);

        if ($lastVerifiedId) {
            // Hapus cache biar hanya muncul sekali
            Cache::forget('last_verified_pesanan_id_user_' . $userId);

            return response()->json([
                'verified' => true,
                'pesanan_id' => $lastVerifiedId,
            ]);
        }

        return response()->json(['verified' => false]);
    }
}
