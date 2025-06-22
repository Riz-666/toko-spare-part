<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // GET /api/kategori
    public function index()
    {
        return response()->json(Kategori::all(), 200);
    }

    // GET /api/kategori/{id}
    public function show($id)
    {
        $kategori = Kategori::find($id);
        if (!$kategori) return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        return response()->json($kategori, 200);
    }

    // POST /api/kategori
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100'
        ]);

        $kategori = Kategori::create([
            'nama' => $request->nama
        ]);

        return response()->json($kategori, 201);
    }

    // PUT /api/kategori/{id}
    public function update(Request $request, $id)
    {
        $kategori = Kategori::find($id);
        if (!$kategori) return response()->json(['message' => 'Kategori tidak ditemukan'], 404);

        $kategori->update([
            'nama' => $request->nama
        ]);

        return response()->json($kategori, 200);
    }

    // DELETE /api/kategori/{id}
    public function destroy($id)
    {
        $kategori = Kategori::find($id);
        if (!$kategori) return response()->json(['message' => 'Kategori tidak ditemukan'], 404);

        $kategori->delete();
        return response()->json(['message' => 'Kategori berhasil dihapus'], 200);
    }
}
