<?php

namespace App\Http\Controllers;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    // private function generateNoInvoice() {
    //     $tanggal = Carbon::now();
    //     $tahun = $tanggal->format('Y');
    //     $bulan = $tanggal->format('m');
    //     $tanggal = $tanggal->format('d');

    //     $last_invoice_number = Penjualan::orderBy('created_at', 'desc')->pluck('no_penjualan')->first();
    //     $next_invoice_number = ($last_invoice_number ? (int)substr($last_invoice_number, -4) + 1 : 1);
    //     $next_invoice_number_padded = str_pad($next_invoice_number, 4, '0', STR_PAD_LEFT);
    //     $no_invoice = $tahun . $bulan . $tanggal . $next_invoice_number_padded;
    //     return $no_invoice;
    // }
    private function generateNoInvoice() {
        $tanggal = Carbon::now();
        $tahun = $tanggal->format('Y');
        $bulan = $tanggal->format('m');
        $tanggal = $tanggal->format('d');

        $last_invoice_number = Penjualan::orderBy('created_at', 'desc')->pluck('no_penjualan')->first();

        $next_invoice_number = ($last_invoice_number ? (int)substr($last_invoice_number, -4) + 1 : 1);

        $next_invoice_number_padded = str_pad($next_invoice_number, 4, '0', STR_PAD_LEFT);

        $no_invoice = $tahun . $bulan . $tanggal . $next_invoice_number_padded;

        return $no_invoice;
    }


    public function index(){
        $title = 'Transaksi - My pos';
        $data = DB::table('produk_m as pm')
        ->leftJoin('kategori_m as km', 'km.id','=','pm.kategori_id')
        ->select('km.*','pm.*','pm.id as pmid','pm.tgl_kadaluarsa')
        ->where('pm.statusenabled', 0)
        ->where('km.statusenabled', 0)
        ->get();
        // return $data;
        $no_invoice = $this->generateNoInvoice();

        return view('penjualan.index',compact('title','no_invoice','data'));
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
            ->select('km.*','pm.*','pm.id as pmid','pm.tgl_kadaluarsa','pj.*')
            ->where('pj.statusenabled', 1)
            ->where('pj.no_penjualan',$request['noinvoice'])
            ->get();
            // dd( $data);
            return view('cetakan.cetakanbill',compact('title','data'));
    }
}
