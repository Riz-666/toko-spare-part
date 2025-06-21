<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $kategori = [
            ['nama' => 'Mesin'],
            ['nama' => 'Rem'],
            ['nama' => 'Aki'],
        ];

        foreach ($kategori as $data) {
            Kategori::create($data);
        }
    }
}

