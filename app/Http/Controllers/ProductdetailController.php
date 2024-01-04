<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\productdetail;
use Illuminate\Http\Request;

class ProductdetailController extends Controller
{
    public function getbyVisitId($visitid){
        return response()->json([
            "status"    => true,
            "message"   => "berhasil",
            "data"      => productdetail::where('visit_id',$visitid)->get()
        ]);
    }
    public function getbyproductId($id){
        return response()->json([
            "status"    => true,
            "message"   => "berhasil",
            "data"      => productdetail::where('productId',$id)->get()
        ]);
    }
    public function update($id, Request $req){
        try {
            $produkdetail = productdetail::findOrFail($id);
            $hasil = $produkdetail->update([
                "merek"     => $req->deskripsi,
                "ukuran"    => $req->jenis,
                "SN"        => $req->sn
            ]);
            return response()->json([
                "status"    => true,
                "message"   => "berhasil",
                "data"      => $produkdetail
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message"=> "Gagal Menambahkan Data Visit ",
                "data"   => $th->getMessage()
            ]);
        }
    }
}
