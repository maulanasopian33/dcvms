<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(product $product)
    {
        //
    }

    public function getdatalimit(Request $req){
        if($req['limit'] === 'all'){
            $data = product::where('id_user',$req['id'])
            ->where('productName','LIKE', '%Server%')
            // ->where('productName', 'not like', "%Dedicate%")
            ->get();
        }else{
            $data = product::where('id_user',$req['id'])
            ->where('productName','LIKE', '%server%')
            ->where('productName', 'not like', "%Dedicate%")
            ->limit($req['limit'])->get();
        }
        return response()->json([
            "data" => $data
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(product $product)
    {
        //
    }
}
