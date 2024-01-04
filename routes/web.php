<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\dcvms;
use App\Http\Controllers\SuratController;
use App\Models\surat;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Route;
use Jumbojett\OpenIDConnectClient;
use DarthSoup\WhmcsApi\Client;
use Illuminate\Http\Request;
use Ilovepdf\OfficepdfTask;
use PhpOffice\PhpWord\Settings;
use Laravel\Socialite\Facades\Socialite;
use ParagonIE\ConstantTime\Base64;
use ParagonIE\ConstantTime\Base64UrlSafe;
use PhpOffice\PhpWord\Element\Image;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\TemplateProcessor;

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
    // return view('welcome');
});

// Route::get('/callback', function(){
//     $client = new Client();
//         $client->authenticate(env('WHMCS_API_IDENTIFIER'), env('WHMCS_API_SECRET'), Client::AUTH_API_CREDENTIALS);
//         $client->url(env('WHMCS_API_URL'));
//         $clientProduct = $client->Authentication()->listOAuthCredentials();
//     return $clientProduct;
// });
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
    return urlencode(base64_encode('40/ANT/XII/23'));
});
