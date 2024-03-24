<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterProdukController extends Controller
{
    public function kategori(){
        $title = 'Master Kategori';
        return view('master.master_kategori',compact('title'));
    }

    public function produk(){
        $title = 'Master Produk';
        return view('master.master_produk',compact('title'));
    }
}
