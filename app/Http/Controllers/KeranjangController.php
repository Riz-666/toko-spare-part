<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\KeranjangItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function cekKeranjang()
    {
        $user = Auth::user();
        $keranjang = $user->keranjang ?? Keranjang::create(['user_id' => $user->id]);

        $keranjang = $user->keranjang()->with('item.produk')->first();
        return view('cekKeranjang', [
            'keranjang' => $keranjang,
        ]);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
        ]);

        $user = Auth::user();

        // Cari atau buat keranjang
        $keranjang = Keranjang::firstOrCreate([
            'user_id' => $user->id,
        ]);

        // Tambah item ke keranjang
        KeranjangItem::create([
            'keranjang_id' => $keranjang->id,
            'produk_id' => $request->produk_id,
            'jumlah' => 1,
        ]);

        return back()->with('success', 'Produk dimasukkan ke keranjang');
    }

    public function updateJumlah(Request $request, $id)
    {
        $item = KeranjangItem::findOrFail($id);
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $item->jumlah = $request->jumlah;
        $item->save();

        return back()->with('success', 'Jumlah item diperbarui.');
    }

    public function hapus($id)
    {
        $item = KeranjangItem::findOrFail($id);

        // Cek agar hanya user yang punya keranjang yang bisa hapus
        if ($item->keranjang->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $item->delete();

        return back()->with('success', 'Item berhasil dihapus dari keranjang');
    }

    public function checkout()
    {
        $user = auth()->user();
        $keranjang = $user->keranjang()->with('items.produk')->first();

        if (!$keranjang || $keranjang->items->isEmpty()) {
            return back()->with('error', 'Keranjang kosong.');
        }

        $total = 0;

        foreach ($keranjang->items as $item) {
            $total += $item->produk->harga * $item->jumlah;
        }

        // Bisa redirect ke form alamat, atau simpan langsung pesanan di sini
        return view('checkout', compact('keranjang', 'total'));
    }
}
