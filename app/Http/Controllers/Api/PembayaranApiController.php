<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class PembayaranApiController extends Controller
{
    // Upload bukti pembayaran
    public function store(Request $request)
    {
        $request->validate([
            'pesanan_id' => 'required|exists:pesanan,id',
            'metode' => 'required|in:qris,kartu_kredit,dana,cod',
            'bukti_bayar' => 'required|image|max:2048',
        ]);

        $pesanan = Pesanan::where('id', $request->pesanan_id)
                          ->where('user_id', Auth::id())
                          ->first();

        if (!$pesanan) {
            return response()->json(['message' => 'Pesanan tidak ditemukan atau bukan milik Anda'], 404);
        }

        // Upload bukti bayar
        $buktiPath = $request->file('bukti_bayar')->store('bukti-bayar', 'public');

        // Simpan pembayaran
        $pembayaran = Pembayaran::create([
            'pesanan_id' => $pesanan->id,
            'metode' => $request->metode,
            'status' => 'menunggu verifikasi',
            'bukti_bayar' => $buktiPath,
            'tanggal_bayar' => now()
        ]);

        // Update status pesanan
        $pesanan->update(['status' => 'diproses']);

        return response()->json([
            'message' => 'Bukti pembayaran berhasil dikirim',
            'data' => $pembayaran
        ], 201);
    }

    // Lihat detail pembayaran berdasarkan pesanan
    public function show($pesanan_id)
    {
        $pembayaran = Pembayaran::where('pesanan_id', $pesanan_id)
            ->whereHas('pesanan', function ($q) {
                $q->where('user_id', Auth::id());
            })->first();

        if (!$pembayaran) {
            return response()->json(['message' => 'Pembayaran tidak ditemukan'], 404);
        }

        return response()->json($pembayaran);
    }
}
