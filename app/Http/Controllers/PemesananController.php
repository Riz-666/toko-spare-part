<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pesanan;
use App\Models\PesananItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil semua item dari semua pesanan user
        $items = PesananItem::with(['produk', 'pesanan'])
            ->whereHas('pesanan', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->join('pesanan', 'pesanan_item.pesanan_id', '=', 'pesanan.id')
            ->orderByRaw("FIELD(pesanan.status, 'diproses', 'dikirim', 'menunggu', 'selesai', 'dibatalkan')")
            ->select('pesanan_item.*') // penting! agar kolom yang digunakan tetap dari pesanan_item
            ->get();

        return view('pemesanan', [
            'judul' => 'Kelola Pesanan',
            'items' => $items,
        ]);
    }

    public function destroy(string $id)
    {
        $pesanan = Pesanan::with('pembayaran')->findOrFail($id);

        // Hapus file bukti bayar jika ada
        if ($pesanan->pembayaran && $pesanan->pembayaran->bukti_bayar) {
            $filePath = public_path('storage/bukti-bayar/' . $pesanan->pembayaran->bukti_bayar);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Hapus pesanan -> otomatis hapus pembayaran karena cascade
        $pesanan->delete();

        return redirect()->route('detail.pemesanan')->with('success');
    }

    public function cetak($id)
    {
        $user = Auth::user();

        $pesanan = Pesanan::with('item.produk', 'pembayaran')->where('id', $id)->where('user_id', $user->id)->findOrFail($id);
        $bukti = Pembayaran::get();

        return view('bukti_pemesanan.cetak', [
            'pesanan' => $pesanan,
            'bukti' => $bukti,
        ]);
    }

    public function batalkan($id)
    {
        $user = Auth::user();

        $pesanan = Pesanan::where('id', $id)
            ->where('user_id', $user->id)
            ->where('status', 'menunggu') // hanya bisa batalkan kalau status menunggu
            ->firstOrFail();

        $pesanan->update([
            'status' => 'dibatalkan',
        ]);

        return redirect()->route('detail.pemesanan')->with('success');
    }
}
