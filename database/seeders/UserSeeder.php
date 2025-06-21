<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('user')->insert([
            'nama' => 'Admin Toko',
            'email' => 'admin@tokosparepart.com',
            'password' => Hash::make('password'),
            'telepon' => '081234567890',
            'alamat' => 'Jl. Sparepart No.1',
            'role' => 'admin',
        ]);

        DB::table('user')->insert([
            'nama' => 'Budi Customer',
            'email' => 'budi@customer.com',
            'password' => Hash::make('password'),
            'telepon' => '082345678901',
            'alamat' => 'Jl. Pelanggan Setia No.2',
            'role' => 'customer',
        ]);
    }
}

