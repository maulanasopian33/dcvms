<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\product;
use App\Models\teams;
use App\Models\User;
use Illuminate\Http\Request;
use DarthSoup\WhmcsApi\Client;
use Illuminate\Support\Str;
class dcvms extends Controller
{
    /**
     * Display a listing of the resource.
     */
    static function syncNow($id)
    {
        $client = new Client();
        $client->authenticate(env('WHMCS_API_IDENTIFIER'), env('WHMCS_API_SECRET'), Client::AUTH_API_CREDENTIALS);
        $client->url(env('WHMCS_API_URL'));
        $clientProduct = $client->Client()->getClientsProducts(['clientid'=>$id]);
        $clientData = $client->Client()->getClientsDetails(['clientid'=>$id]);

        $data['data']       = $clientData;
        $data['product']    = $clientProduct;

        $user = User::find($id);
        if($user){
            return self::prosessData($data,$user,$id);
        }else{
            return self::prosessData($data,new User(),$id);
        }

    }
    static public function getProduct(){
        $client = new Client();
        $client->authenticate(env('WHMCS_API_IDENTIFIER'), env('WHMCS_API_SECRET'), Client::AUTH_API_CREDENTIALS);
        $client->url(env('WHMCS_API_URL'));
        $clientProduct = $client->Client()->getClientsProducts(['clientid'=>1]);
        return $clientProduct;
    }
    static public function prosessData($data,$user, $pos){
        // sync Data user
        $user->id_user  = $pos;
        $user->name     = $data['data']['fullname'];
        $user->email    = $data['data']['email'];
        $user->save();
        // sync Data Product
        $products = $data['product']['products']['product'];
        foreach ($products as $key => $value) {
            $cek = product::where('orderId',$value['orderid'])->first();
            $product = new product();
            if ($cek) {
                // Data ditemukan
                $product = $cek;
            } else {
                // Data tidak ditemukan
                $product = new Product();
            }
            $product->orderId       = $value['orderid'];
            $product->id_user       = $pos;
            $product->productName   = $value['translated_groupname'];
            $product->domain        = $value['domain'];
            $product->status        = $value['status'];
            $product->regDate       = $value['regdate'];
            $user->product()->save($product);
        }

        return response()->json([
            'data' => [
                'user' => $user,
                'product' => $product
            ]
        ]);


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
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
