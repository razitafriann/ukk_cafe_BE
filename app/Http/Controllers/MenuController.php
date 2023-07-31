<?php

namespace App\Http\Controllers;

use App\Models\Menu;
// use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    public function getmenu()
    {
        $getmenu = Menu::get();
        return response()->json($getmenu);
    }

    public function selectmenu($id)
    {
        $getmenu = Menu::where('id_menu', $id)->get();
        return response()->json($getmenu);
    }

    public function createmenu(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'nama' => 'required',
            'jenis' => 'required',
            'harga' => 'required',
            // 'jumlah_pesan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->tojson());
        }

        $imagename = time() . '.' . $req->foto->extension();
        $req->foto->move(public_path('images'), $imagename);

        $create = Menu::create([
            'nama' => $req->input('nama'),
            'jenis' => $req->input('jenis'),
            'harga' => $req->input('harga'),
            'foto' => $imagename
        ]);

        if ($create) {
            return response()->json(['Message' => 'Berhasil']);
        } else {
            return response()->json(['Message' => 'Gagal']);
        }
    }

    public function updatemenu(Request $r, $id)
    {
        // $imagename = time().'.'.$r->foto->extension();
        // $r->foto->move(public_path('images'), $imagename);

        $update = Menu::where('id_menu', $id)->update([
            'nama' => $r->input('nama'),
            'jenis' => $r->input('jenis'),
            'harga' => $r->input('harga'),
            // 'foto' => $imagename
        ]);

        if ($update) {
            return response()->json(['Message' => 'Berhasil']);
        } else {
            return response()->json(['Message' => 'Gagal']);
        }
    }

    public function updatephoto(Request $req, $id)
    {
        $imagename = time() . '.' . $req->foto->extension();
        $req->foto->move(public_path('images'), $imagename);

        $update = Menu::where('id_menu', $id)->update([
            'foto' => $imagename
        ]);

        return response()->json([
            "Message" => "Berhasil",
            "Result" => $update
        ]);
    }

    public function deletemenu($id)
    {
        $delete = DB::table('menus')->where('id_menu', $id)->delete();
        if ($delete) {
            return response()->json('Berhasil');
        } else {
            return response()->json('Menu Tidak Ada / Sudah Terhapus');
        }
    }
}
