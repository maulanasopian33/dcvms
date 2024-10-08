<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\requestdc;
use App\Models\product;
use App\Models\teams;
use App\Models\User;
use Illuminate\Http\Request;
use DarthSoup\WhmcsApi\Client;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Http\Controllers\vpnController;
class dcvms extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function sendemailrequest(Request $request){
        $mailData = [
            'subject'       => "Request Visit DC",
            'name'          => $request->name,
            'from'          => env('MAIL_FROM_ADDRESS'),
            'url'           => $request->url
        ];
        Mail::to($request->email)->send(new requestdc($mailData));
        return response()->json([
            "status"    => true,
            "message"   => "berhasil mengirim email",
            "data"      => ''

        ]);
    }
    static function syncNowAll()
    {
        $client = new Client();
        $client->authenticate(env('WHMCS_API_IDENTIFIER'), env('WHMCS_API_SECRET'), Client::AUTH_API_CREDENTIALS);
        $client->url(env('WHMCS_API_URL'));
        $clients        = $client->Client()->getClients();
        $test = [];
        foreach ($clients['clients']['client'] as $key => $value) {
            $clientProduct  = $client->Client()->getClientsProducts(['clientid'=>$value['id']]);
            $clientData     = $client->Client()->getClientsDetails(['clientid'=>$value['id']]);

            $data['data']       = $clientData;
            $data['product']    = $clientProduct;

            $user = User::find($value['id']);
            if($user){
                self::prosessData($data,$user,$value['id']);
            }else{
                self::prosessData($data,new User(),$value['id']);
            }
        }
        return "Done";
    }
    static function syncNow($id)
    {
        $client = new Client();
        $client->authenticate(env('WHMCS_API_IDENTIFIER'), env('WHMCS_API_SECRET'), Client::AUTH_API_CREDENTIALS);
        $client->url(env('WHMCS_API_URL'));
        $clients        = $client->Client()->getClients();
        $clientProduct  = $client->Client()->getClientsProducts(['clientid'=>(int)$id]);
        $clientData     = $client->Client()->getClientsDetails(['clientid'=>(int)$id]);
        $filteredData = [];

        foreach ($clientProduct['products']['product'] as $item) {
            if (strpos($item['groupname'], 'Colocation') !== false) {
                $filteredData[] = $item;
            }
        }

        $data['data']       = $clientData;
        $data['product']    = $filteredData;

        $user = User::find($id);
        if($user){
            self::prosessData($data,$user,$id);
        }else{
            self::prosessData($data,new User(),$id);
        }
        return $data;
    }
    static public function getdata($data){
        $client = new Client();
        $client->authenticate(env('WHMCS_API_IDENTIFIER'), env('WHMCS_API_SECRET'), Client::AUTH_API_CREDENTIALS);
        $client->url(env('WHMCS_API_URL'));
        $clientData = $client->Client()->getClientsDetails(['email'=>$data['email']]);
        $user = User::find($clientData['client_id']);
        if(self::syncNow($clientData['client_id'])){
            $token = $user->createToken('API Token',['user'])->accessToken;
            $data = [
                "userId"    => $clientData['client_id'],
                "token"     => $token
            ];
            return redirect(env("FE_URL").'login/'.base64_encode(json_encode($data)));
        }
    }
    static public function getProduct(){
        $client = new Client();
        $client->authenticate(env('WHMCS_API_IDENTIFIER'), env('WHMCS_API_SECRET'), Client::AUTH_API_CREDENTIALS);
        $client->url(env('WHMCS_API_URL'));
        $clientProduct = $client->Client()->getClientsProducts(['clientid'=>3]);

        if($clientProduct['products'] !== ''){
        }
        return $clientProduct;
        // return 'kosong';
    }
    static public function getProducts(){
        $client = new Client();
        $client->authenticate(env('WHMCS_API_IDENTIFIER'), env('WHMCS_API_SECRET'), Client::AUTH_API_CREDENTIALS);
        $client->url(env('WHMCS_API_URL'));
        $clientProduct = $client->orders()->getProducts();

        if($clientProduct['products'] !== ''){
        }
        return $clientProduct;
        // return 'kosong';
    }
    static public function prosessData($data,$user, $pos){
        // sync Data user
        $user->id_user  = $pos;
        $user->name     = $data['data']['fullname'];
        $user->email    = $data['data']['email'];
        $user->phone    = $data['data']['phonenumber'];
        $user->address  = $data['data']['address1'];
        $user->company_name = $data['data']['companyname'];
        $user->company_address = $data['data']['address1'];
        $user->no_npwp = $data['data']['customfields1'];
        $user->save();
        // sync Data Product
        if($data['product'] !== ''){
            $products = $data['product'];
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
                $product->productName   = $value['translated_name'].'/'.$value['translated_groupname'];
                $product->domain        = $value['domain'];
                $product->status        = $value['status'];
                $product->regDate       = $value['regdate'];
                $user->product()->save($product);
            }
        }
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
