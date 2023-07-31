<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\Meja;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MejaController extends Controller
{
    public function getmeja()
    {
        $getmeja = Meja::get();
        return response()->json($getmeja);
    }

    public function mejatersedia()
    {
        $meja = Meja::where('status', '!=' ,'digunakan')->get();
            return response()->json($meja);
    }   

    public function selectmeja($id)
    {
        $getmeja = Meja::where('id_meja', $id)->get();
        return response()->json($getmeja);
    }

    public function createmeja(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'nomor_meja' => 'required|unique:mejas'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 422);
        }

        $createmeja = Meja::create([
            'nomor_meja' => $req->input('nomor_meja'),
            'status' => 'kosong'
        ]);

        return response()->json([
            'Message' => 'Sukses tambah meja'
        ]);
    }

    public function updatemeja(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'nomor_meja' => 'required',
            // 'status' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson());
        }

        $update = Meja::where('id_meja', $id)->update([
            'nomor_meja' => $req->input('nomor_meja'),
            'status' => $req->input('status')
        ]);

        if ($update) {
            return response()->json('Sukses');
        } else {
            return response()->json('gagal');
        }
    }

    public function deletemeja($id)
    {
        $delete = DB::table('mejas')->where('id_meja', $id)->delete();
        if ($delete) {
            return response()->json('Berhasil Hapus meja');
        } else {
            return response()->json('Meja sudah tidak ada/terhapus');
        }
    }
}
