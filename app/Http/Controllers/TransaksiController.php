<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Menu;
use App\Models\Meja;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function getdate($date)
    {
        $get = Transaksi::where('tanggal_pesan', $date)->sum('total_harga');
        return response()->json($get);
    }

    public function getmonth($month)
    {
        $get = Transaksi::whereMonth('tanggal_pesan', substr($month, 5, 2))->sum('total_harga');
        return response()->json($get);
    }

    public function gettransaksi()
    {
        $gettransaksi = Transaksi::get();
        return response()->json($gettransaksi);
    }

    public function gethistory()
    {
        $get = DB::table('history')
            ->join('users', 'history.id_user', '=', 'users.id_user')
            ->orderBy('id_history', 'desc')->get();
        return response()->json($get);
    }

    public function selecthistory($code)
    {
        $get = DB::table('transaksis')
            ->where('id_pelayanan', $code)
            ->join('users', 'transaksis.id_user', '=', 'users.id_user')
            ->join('menus', 'transaksis.id_menu', '=', 'menus.id_menu')
            ->get();
        return response()->json($get);
    }

    public function ongoing()
    {
        $get = Meja::where('status', 'digunakan')->get();
        return response()->json($get);
    }

    public function getongoingtransaksi($id)
    {   
        $gettransaksi = Transaksi::where('id_meja', $id)
            ->where('status', 'belum_lunas')
            ->first();
        return response()->json($gettransaksi);
    }

    public function total($code)
    {
        $get = Transaksi::where('id_pelayanan', $code)->sum('total_harga');
        return response()->json($get);
    }

    public function totalharga($id)
    {
        $gettotal = Transaksi::where('id_meja', $id)->where('status', 'belum_lunas')->sum('total_harga');
        return response()->json($gettotal);
    }

    public function getcart()
    {
        $cart = Transaksi::where('id_meja', null)
            ->join('menus', 'transaksis.id_menu', '=', 'menus.id_menu')
            ->get();
        return response()->json($cart);
    }

    public function selecttransaksi($id)
    {
        $gettransaksi = Transaksi::where('id_pelayanan', $id)->get();
        return response()->json($gettransaksi);
    }

    public function tambahpesanan(Request $req)
    {
        $harga_menu = DB::table('menus')->where('id_menu', $req->input('id_menu'))->select('harga')->first();
        $harga_menu = $harga_menu->harga;

        $tgl_pesan = Carbon::now();
        $total_pesanan = $req->input('total_pesanan');
        $total_harga = $harga_menu * $total_pesanan;

        $tambah = Transaksi::create([
            'id_menu' => $req->input('id_menu'),
            'tanggal_pesan' => $tgl_pesan,
            'total_pesanan' => $total_pesanan,
            'total_harga' => $total_harga,
            'status' => 'belum_lunas'
        ]);

        $get = DB::table('menus')->where('id_menu', $req->input('id_menu'))->select('jumlah_pesan')->get();
        $jumlah_pesan = $get->isEmpty() ? 0 : $get[0]->jumlah_pesan;
        $addjumlahpesan = $jumlah_pesan + $total_pesanan;

        $add = DB::table('menus')->where('id_menu', $req->input('id_menu'))->update([
            'jumlah_pesan' => $addjumlahpesan
        ]);

        if ($tambah) {
            return response()->json('Berhasil');
        } else {
            return response()->json('Gagal');
        }
    }

    public function checkout(Request $req)
    {
        $id_pelayanan = Str::random(5);

        $checkout = Transaksi::where('id_pelayanan', null)->update([
            'id_pelayanan' => $id_pelayanan,
            'id_user' => $req->input('id_user'),
            'id_meja' => $req->input('id_meja'),
            'nama_pelanggan' => $req->input('nama_pelanggan')
        ]);

        $history = DB::table('history')->insert([
            'id_pelayanan' => $id_pelayanan,
            'tgl_transaksi' => Carbon::now(),
            'id_user' => $req->input('id_user'),
            'nama_pelanggan' => $req->input('nama_pelanggan')
        ]);

        $updatemeja = Meja::where('id_meja', $req->input('id_meja'))->update([
            'status' => 'digunakan'
        ]);

        if ($checkout && $updatemeja && $history) {
            return response()->json('Berhasil');
        } else {
            return response()->json('Gagal');
        }
    }

    public function donetransaksi($id)
    {
        $done = Transaksi::where('id_meja', $id)->where('status', 'belum_lunas')->update([
            'status' => 'lunas'
        ]);

        $meja = Meja::where('id_meja', $id)->update([
            'status' => 'kosong'
        ]);

        if ($done && $meja) {
            return response()->json([
                'Message' => 'Sukses'
            ]);
        } else {
            return response()->json([
                'Message' => 'gagal'
            ]);
        }
    }

    function printharga($id) {
        $get = DB::table('transaksis')->where('id_pelayanan',$id)->sum('total_harga');
            return response() -> json($get);
     }
}
