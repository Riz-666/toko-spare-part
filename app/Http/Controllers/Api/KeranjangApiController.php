<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\KeranjangItem;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangApiController extends Controller
{
    public function index()
    {
        $keranjang = Auth::user()->keranjang()->with('item.produk')->first();
        return response()->json($keranjang);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
        ]);

        $user = Auth::user();
        $keranjang = $user->keranjang ?? Keranjang::create(['user_id' => $user->id]);

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

        return response()->json(['message' => 'Produk ditambahkan ke keranjang']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $item = KeranjangItem::findOrFail($id);
        $item->jumlah = $request->jumlah;
        $item->save();

        return response()->json(['message' => 'Jumlah produk diperbarui']);
    }

    public function hapus($id)
    {
        $item = KeranjangItem::findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Item keranjang dihapus']);
    }
}

