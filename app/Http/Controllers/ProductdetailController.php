<?php

namespace App\Http\Controllers;

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
}
