<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterProdukController extends Controller
{
    public function kategori(){
        $title = 'Master Kategori';
        $data = DB::table('kategori_m')
        ->where('statusenabled',1)
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
            'statusenabled' => 1,
        ]);
        $kategori->save();

        return redirect()->route('kategori')->with('success', 'Data Berhasil Di Tambahkan');
    }

    public function hapus($id){
        // return 'sini';
        DB::table('kategori_m')->where('id', $id)
        ->update([
            'statusenabled' => 0,
        ]);
        return redirect()->route('kategori')->with('success', 'Data Berhasil Di Hapus');
    }

    public function produk(){
        $title = 'Master Produk';

        $data = DB::table('produk_m as pm')
        ->leftJoin('kategori_m as km', 'km.id','=','pm.kategori_id')
        ->select('km.*','pm.*','pm.id as pmid')
        ->where('pm.statusenabled', 1)
        ->where('km.statusenabled', 1)
        ->get();

        $kategori = DB::table('kategori_m')
        ->where('statusenabled',1)
        ->get();

        return view('master.master_produk',compact('title','data','kategori'));
    }

    public function produk_aksi(Request $request)
    {
        $request->validate([
            'position_id' => 'required',
            'namaproduk' => 'required',
            'stok' => 'required',
            'harga' => 'required',
            'tgl_exp' => 'required',
        ]);
        try {
            $produk = new Produk([
                'kategori_id' => $request->position_id,
                'namaproduk' => $request->namaproduk,
                'stok' => $request->stok,
                'harga' => $request->harga,
                'tgl_kadaluarsa' => $request->tgl_exp,
                'statusenabled' => 1,
            ]);

            $produk->save();

            return redirect()->route('produk')->with('success', 'Data Berhasil Di Tambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data produk: ' . $e->getMessage());
        }

    }

    public function hapusproduk($id){
        DB::table('produk_m')->where('id', $id)
        ->update([
            'statusenabled' => 0,
        ]);

        return redirect()->route('produk')->with('success', 'Data Berhasil Di Hapus');
    }

}
