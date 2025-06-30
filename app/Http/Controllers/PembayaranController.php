<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayaran = Pembayaran::with(['pesanan'])->get();
        $pesanan = Pesanan::get();
        return view('admin.pembayaran.pembayaran', [
            'pembayaran' => $pembayaran,
            'pesanan' => $pesanan,
            'judul' => 'Kelola Pembayaran',
        ]);
    }

    public function edit(string $id)
    {
        $pembayaran = Pembayaran::with(['pesanan'])->findOrFail($id);
        return view('admin.pembayaran.edit', [
            'judul' => 'Verifikasi Pembayaran',
            'pembayaran' => $pembayaran,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $rules = [
            'status' => 'required',
        ];

        $validatedData = $request->validate($rules);

        $pembayaran->status = $request->status;

        $pembayaran->save($rules);

        return redirect()->route('kelola.pembayaran')->with('success', 'Berhasil Memperbarui Status');
    }

    public function destroy(string $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();

        return redirect()->route('kelola.pembayaran')->with('success');
    }

    public function upload(Request $request, $id)
{
    $request->validate([
        'bukti_bayar' => 'required|image|mimes:jpeg,jpg,png|max:2048',
    ]);

    $pesanan = Pesanan::findOrFail($id);

    $file = $request->file('bukti_bayar');
    $filename = time() . '_' . $file->getClientOriginalName();

    // Simpan file ke storage/app/public/bukti-bayar
    $file->storeAs('public/bukti-bayar', $filename);

    Pembayaran::create([
        'pesanan_id' => $pesanan->id,
        'metode_pembayaran' => $pesanan->metode_pembayaran, // <- pastikan nama fieldnya benar
        'status' => 'menunggu verifikasi',
        'bukti_bayar' => $filename,
        'tanggal_bayar' => now(),
    ]);

    return redirect()->route('index')->with('success', 'Pesanan akan di cek oleh admin');
}

}
