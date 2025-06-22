<?php

namespace App\Http\Controllers;

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
        'items' => $items
    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
