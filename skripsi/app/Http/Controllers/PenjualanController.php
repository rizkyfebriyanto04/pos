<?php

namespace App\Http\Controllers;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{


    public function index(){
        $title = 'Transaksi - My pos';
        $data = DB::table('produk_m as pm')
        ->leftJoin('kategori_m as km', 'km.id','=','pm.kategori_id')
        ->select('km.*','pm.*','pm.id as pmid','pm.tgl_kadaluarsa')
        ->where('pm.statusenabled', 1)
        ->where('km.statusenabled', 1)
        ->where('pm.stok','<>',0)
        ->get();
        // return $data;

        return view('penjualan.index',compact('title','data'));
    }

    public function transaksi(Request $request){
        try {
            $data = $request->input('data');
            $no_invoice = date('Ymd') . sprintf('%04d', Penjualan::count() + 1);
            $keterangan = $request->input('keterangan');
            $bayar = $request->input('bayar');

            $decodedData = [];
            if (!empty($data)) {
                $decodedData = json_decode($data, true);
            }
            // return $decodedData;
            if ($decodedData) {
                foreach ($decodedData as $item) {
                    $penjualan = new Penjualan([
                        'statusenabled'=> 1,
                        'no_penjualan' => $no_invoice,
                        'objectprodukfk' => $item['idproduk'],
                        'qty' => $item['jumlah'],
                        'total' => $item['total'],
                        'bayar' => $bayar,
                        'keterangan' => $keterangan,
                        'tanggal_jual' => now(),
                    ]);
                    $penjualan->save();

                    $produk = Produk::findOrFail($item['idproduk']);
                    $produk->kurangiStok($item['jumlah']);
                    $produk->save();
                }

                if (!empty($keterangan)) {
                }

                return response()->json(['message' => 'Data berhasil diterima dan diproses', 'no_invoice' => $no_invoice], 200);
            } else {
                return response()->json(['error' => 'Gagal memproses data'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memproses data: ' . $e->getMessage()], 500);
        }
    }

    public function cetakbill(Request $request){
            $title = 'Struk Bill - My pos';
            $data = DB::table('penjualan_t as pj')
            ->leftJoin('produk_m as pm', 'pm.id','=','pj.objectprodukfk')
            ->leftJoin('kategori_m as km', 'km.id','=','pm.kategori_id')
            ->select('km.namakategori','pm.namaproduk','pm.tgl_kadaluarsa','pj.*')
            ->where('pj.statusenabled', 1)
            ->where('pj.no_penjualan',$request['noinvoice'])
            ->get();
            // dd( $data);
            return view('cetakan.cetakanbill',compact('title','data'));
    }

    public function laporan(Request $request){
        $title = 'Laporan Penjualan - My Pos App';

        $tglawal = $request->input('tglawal', Carbon::today()->toDateString());
        $tglakhir = $request->input('tglakhir', Carbon::today()->toDateString());

        $data = DB::table('penjualan_t as pj')
            ->leftJoin('produk_m as pm', 'pm.id','=','pj.objectprodukfk')
            ->leftJoin('kategori_m as km', 'km.id','=','pm.kategori_id')
            ->select('km.*','pm.*','pm.id as pmid','pj.*')
            ->where('pj.statusenabled', 1)
            ->whereBetween('pj.tanggal_jual', [$tglawal, $tglakhir])
            ->get();

        return view('laporan.index',compact('title','data'));
    }
}
