<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::with(['kategori'])->get();
        return view('admin.produk.produk', [
            'produk' => $produk,
            'judul' => 'Kelola Produk'
        ]);
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('admin.produk.add', [
            'kategori' => $kategori,
            'judul' => 'Tambah Produk'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'nama' => 'required|max:255',
            'deskripsi' => 'required',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
            'gambar' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
        ], [
            'gambar.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png atau gif.',
            'gambar.max' => 'Ukuran file gambar maksimal adalah 2048 KB.',
        ]);

        $filename = null;
        if ($request->hasFile('gambar')) {
            $filename = time() . '_' . $request->file('gambar')->getClientOriginalName();
            $request->file('gambar')->storeAs('public/produk-img', $filename);
        }

        Produk::create([
            'kategori_id' => $request->kategori_id,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'stok' => $request->stok,
            'harga' => $request->harga,
            'gambar' => $filename,
        ]);

        return redirect()->route('kelola.produk')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $edit = Produk::findOrFail($id);
        $kategori = Kategori::all();
        return view('admin.produk.edit', [
            'edit' => $edit,
            'kategori' => $kategori,
            'judul' => 'Edit Produk'
        ]);
    }

    public function update(Request $request, string $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'nama' => 'required|max:255',
            'deskripsi' => 'required',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ], [
            'gambar.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png atau gif.',
            'gambar.max' => 'Ukuran file gambar maksimal adalah 2048 KB.',
        ]);

        $produk->kategori_id = $request->kategori_id;
        $produk->nama = $request->nama;
        $produk->deskripsi = $request->deskripsi;
        $produk->stok = $request->stok;
        $produk->harga = $request->harga;

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($produk->gambar && Storage::exists('public/produk-img/' . $produk->gambar)) {
                Storage::delete('public/produk-img/' . $produk->gambar);
            }

            $filename = time() . '_' . $request->file('gambar')->getClientOriginalName();
            $request->file('gambar')->storeAs('public/produk-img', $filename);
            $produk->gambar = $filename;
        }

        $produk->save();

        return redirect()->route('kelola.produk')->with('success', 'Produk berhasil diubah.');
    }

    public function destroy(string $id)
    {
        $produk = Produk::findOrFail($id);

        // Hapus gambar dari storage
        if ($produk->gambar && Storage::exists('public/produk-img/' . $produk->gambar)) {
            Storage::delete('public/produk-img/' . $produk->gambar);
        }

        $produk->delete();

        return redirect()->route('kelola.produk')->with('success', 'Produk berhasil dihapus.');
    }
}
