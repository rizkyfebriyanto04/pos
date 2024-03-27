<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterProdukController extends Controller
{
    public function kategori(){
        $title = 'Master Kategori';
        $data = DB::table('kategori_m')
        ->where('statusenabled',0)
        ->get();
        // return $data;
        return view('master.master_kategori',compact('title','data'));
    }

    public function kategori_aksi(Request $request)
    {
        $request->validate([
            'namakategori' => 'required',
        ]);

        $kategori = new Kategori([
            'namakategori' => $request->namakategori,
            'statusenabled' => 0,
        ]);
        $kategori->save();

        return redirect()->route('kategori')->with('success', 'Data Berhasil Di Tambahkan');
    }

    public function produk(){
        $title = 'Master Produk';
        return view('master.master_produk',compact('title'));
    }
}
