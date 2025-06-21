<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;

class ProdukSeeder extends Seeder
{
    public function run()
    {
        Produk::create([
            'kategori_id' => 1,
            'nama' => 'Oli Mesin Honda',
            'deskripsi' => 'Oli mesin original untuk motor Honda.',
            'stok' => 50,
            'harga' => 45000,
            'gambar' => 'produk/oli-honda.jpg',
        ]);

        Produk::create([
            'kategori_id' => 2,
            'nama' => 'Kampas Rem Nissin',
            'deskripsi' => 'Kampas rem depan kualitas original.',
            'stok' => 30,
            'harga' => 75000,
            'gambar' => 'produk/rem-nissin.jpg',
        ]);

        Produk::create([
            'kategori_id' => 3,
            'nama' => 'Aki Kering GS Astra',
            'deskripsi' => 'Aki kering untuk motor bebek dan matic.',
            'stok' => 20,
            'harga' => 120000,
            'gambar' => 'produk/aki-gs.jpg',
        ]);
    }
}

