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
    if (Auth::check()) {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            return redirect()->route('admin.index');
        }
    }
    // Ambil semua produk dengan relasi kategorinya
    $produk = Produk::with('kategori')->get();

    // Ambil semua kategori
    $kategori = Kategori::all();

    // Ambil 6 produk terlaris berdasarkan jumlah item yang dibeli
    $bestSelling = Produk::with('kategori') // jika butuh juga data kategori
        ->select(
            'produk.id',
            'produk.nama',
            'produk.harga',
            'produk.gambar',
            'produk.deskripsi',
            'produk.kategori_id',
            
            DB::raw('SUM(pesanan_item.jumlah) as total_terjual')
        )
        ->join('pesanan_item', 'produk.id', '=', 'pesanan_item.produk_id')
        ->groupBy(
            'produk.id',
            'produk.nama',
            'produk.harga',
            'produk.gambar',
            'produk.deskripsi',
            'produk.kategori_id'
        )
        ->orderByDesc('total_terjual')
        ->take(6)
        ->get();

    // Tampilkan ke halaman index
    return view('index', [
        'kategori' => $kategori,
        'produk' => $produk,
        'bestSelling' => $bestSelling,
        'judul' => 'Lestari Motor'
    ]);
}

    public function edit()
    {
        $user = Auth::user();
        return view('profile', [
            'user' => $user,
            'judul' => 'Profile'
        ]);
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

        return redirect()->route('user.edit.profile')->with('success', 'Profil berhasil diperbarui');
    }
}
