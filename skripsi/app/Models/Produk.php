<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk_m';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'kategori_id',
        'namaproduk',
        'statusenabled',
        'stok',
        'harga',
        'tgl_kadaluarsa'
    ];

    public function kurangiStok($jumlah) {
        $produk = $this->findOrFail($this->id);

        $produk->stok -= $jumlah;

        $produk->save();
    }
}
