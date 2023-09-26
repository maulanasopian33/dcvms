<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\dcvms;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Jumbojett\OpenIDConnectClient;
use DarthSoup\WhmcsApi\Client;
use Illuminate\Http\Request;

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
    return view('welcome');
});

Route::get('/callback', function(){
    $client = new Client();
        $client->authenticate(env('WHMCS_API_IDENTIFIER'), env('WHMCS_API_SECRET'), Client::AUTH_API_CREDENTIALS);
        $client->url(env('WHMCS_API_URL'));
        $clientProduct = $client->Authentication()->listOAuthCredentials();
    return $clientProduct;
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

Route::get('/test',function(){
    // $oidc = new OpenIDConnectClient('https://pucukidea.us.auth0.com', // Provider URl
    //                             'Heib6H7ywMakHBopw5cC2UmsH3Oq25Vq', // Client ID
    //                             'moHq9kj2lztlT_X9lH78YbZdnvbKmFooGGuFljMDR1UiQnAqmWpnEPHRsg_wrtO6'); // client secret
// $oidc->setCertPath('/path/to/my.cert');
    $oidc = new OpenIDConnectClient('https://devmy.antmedia.id/oauth/authorize.php', // Provider URl
                                'PT-SEMUT-DATA-IN.4c6d0b56064e2a63fa10657fff829fa4', // Client ID
                                'nFd3xAKPhaJ3fWh8Xf496uqv42wk3fPdlCf1OXUAIYgyFFdPa1JjeHZ95YwpZw36QzwSjs9St2+CSc/vzw0I+A=='); // client secret
$oidc->setRedirectURL('http://localhost:8000/test'); //redirect url
$oidc->authenticate();
$name = $oidc->requestUserInfo('given_name');
return $name;
});


Route::get('/whmcs',function(){
    return dcvms::syncNow(1);
});


Route::get('/product',function(){
    return dcvms::getProduct();
});

// routes/web.php

Route::get('auth/whmcs', [AuthController::class,'redirectToProvider']);
Route::get('auth/whmcs/callback', [AuthController::class,'handleProviderCallback']);

Route::get('/a',function(Request $req){
    return $req;
})->name('datawhmcs');
