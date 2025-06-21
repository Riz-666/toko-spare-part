<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    protected $fillable = ['kategori_id', 'nama', 'deskripsi', 'stok', 'harga', 'gambar'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function keranjangItem()
    {
        return $this->hasMany(KeranjangItem::class, 'produk_id');
    }

    public function pesananItem()
    {
        return $this->hasMany(PesananItem::class, 'produk_id');
    }
}
