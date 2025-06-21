<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\PesananItem;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    public function index()
    {
        $produk = Produk::with('kategori')->get();
        $kategori = Kategori::all();

        $bestSelling = Produk::select('produk.*', DB::raw('SUM(pesanan_item.jumlah) as total_terjual'))
        ->join('pesanan_item', 'produk.id', '=', 'pesanan_item.produk_id')
        ->groupBy('produk.id')
        ->orderByDesc('total_terjual')
        ->take(6) // tampilkan 6 produk terlaris
        ->get();

        return view('index', compact('kategori', 'produk', 'bestSelling'));
        return view('index', [
            'produk' => $produk,
            'kategori' => $kategori,
        ]);
    }

    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update field
        $user->nama = $request->nama;
        $user->telepon = $request->telepon;
        $user->alamat = $request->alamat;

        // Jika upload foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama kalau ada
            if ($user->foto) {
                Storage::delete('public/user-img/' . $user->foto);
            }

            $filename = time() . '.' . $request->foto->extension();
            $request->foto->storeAs('public/user-img', $filename);
            $user->foto = $filename;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui');
    }
}
