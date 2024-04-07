<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualan_t';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'statusenabled',
        'no_penjualan',
        'objectprodukfk',
        'qty',
        'total',
        'bayar',
        'tanggal_jual',

    ];
}
