<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::with(['kategori'])->get();
        return view('admin.produk.produk',[
            'produk' => $produk,
            'judul' => 'Kelola Produk'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produk = Produk::get();
        $kategori = Kategori::all();
        return view('admin.produk.add',[
            'produk' => $produk,
            'kategori' => $kategori,
            'judul' => 'Tambah Produk'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'nama' => 'required|max:255',
            'deskripsi' => 'required',
            'stok' => 'required',
            'harga' => 'required',
            'gambar' => 'required|image|mimes:jpeg,jpg,png,gif|file|max:2048',
        ],$messages = [
            'gambar.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png atau gif.',
            'gambar.max' => 'Ukuran file gambar Maksimal adalah 2048 KB.',
        ]);

        $filePath = public_path('/storage/produk-img');
        if($request->hasFile('gambar')){
            $file = $request->file('gambar');
            $fileName = time() . $request->file('gambar')->getClientOriginalName();
            $file->move($filePath,$fileName);
        }
        $produk = Produk::create([
            'kategori_id' => $request->kategori_id,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'stok' => $request->stok,
            'harga' => $request->harga,
            'gambar' => $fileName,
        ]);


        return redirect()->route('kelola.produk')->with('success','Data Berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $edit = Produk::findOrFail($id);
        $kategori = Kategori::all();
        return view('admin.produk.edit',[
            'edit' => $edit,
            'kategori' => $kategori,
            'judul' => 'Edit Produk'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $produk = Produk::findOrFail($id);
        $rules = [
            'kategori_id' => 'required|exists:kategori,id',
            'nama' => 'required|max:255',
            'deskripsi' => 'required',
            'stok' => 'required',
            'harga' => 'required',
            'gambar' => 'required|image|mimes:jpeg,jpg,png,gif|file|max:2048',
        ];
        $messages = [
            'gambar.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png atau gif.',
            'gambar.max' => 'Ukuran file gambar Maksimal adalah 2048 KB.',
        ];

        $validatedData = $request->validate($rules, $messages);

        $produk->kategori_id = $request->kategori_id;
        $produk->nama = $request->nama;
        $produk->deskripsi = $request->deskripsi;
        $produk->stok = $request->stok;
        $produk->harga = $request->harga;

        if($request->hasFile('gambar')){
            $dir = public_path('storage/produk-img/');
            $file = $request->file('gambar');
            $filename = time() . $file->getClientOriginalName();
            $file->move($dir,$filename);
            if(!is_null($produk->gambar)){
                $oldImagePath = public_path('storage/produk-img/'.$produk->gambar);
                if(file_exists($oldImagePath)){
                    unlink($oldImagePath);
                }
            }
            $produk->gambar = $filename;

        }
            $result = $produk->save($validatedData);
            return redirect()->route('kelola.produk')->with('success','Data Berhasil di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produk = Produk::findOrFail($id);
        if ($produk->gambar) {
            $oldImagePath = public_path('storage/produk-img/') . $produk->gambar;
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        $produk->delete();
        return redirect()->route('kelola.produk')->with('success');
    }
}
