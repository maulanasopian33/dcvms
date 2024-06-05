<?php

use App\Http\Controllers\dcvms;
use App\Http\Controllers\RouterOSAPI;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\vpnController;
use App\Mail\notifMail;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use DarthSoup\WhmcsApi\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return "v1 API DCMS";
});
Route::get('/token',function(){
    $user = User::find(2);
    $token = $user->createToken('API Token')->accessToken;
    $response = ['token' => $token];
    return response($response, 200);
});
Route::get('/login',function(){
    return 'login';
})->name('login');

Route::get('/whmcs',function(){
    // return dcvms::syncNow(1);
    return dcvms::syncNowAll();
});

Route::get('/getdata',function(){
    $client = new Client();
    $client->authenticate(env('WHMCS_API_IDENTIFIER'), env('WHMCS_API_SECRET'), Client::AUTH_API_CREDENTIALS);
    $client->url(env('WHMCS_API_URL'));
    // $clientProduct  = $client->Client()->getClientsProducts(['clientid'=>3]);
    $clientData     = $client->Client()->getClientsDetails(['clientid'=>3]);

    // $data['data']       = $clientData;

    return response()->json($clientData);
});
Route::get('/product',function(){
    return dcvms::getProduct();
});

// routes/web.php

Route::get('/0auth',function(Request $req){
    return Socialite::driver('whmcs')->redirect();
});

Route::get('/callback',function(Request $req){
    $user = Socialite::driver('whmcs')->user();
    return dcvms::getdata($user);
});

Route::get('/surat/i/{id}',[SuratController::class,'suratmasuk']);
Route::get('/surat/o/{id}',[SuratController::class,'suratkeluar']);
Route::get('/base/{id}',function($id){
    return rawUrlEncode(base64_encode('dasdsasdas'));
});

Route::get('/generate/nosurat',[SuratController::class,'generateNosurat']);
