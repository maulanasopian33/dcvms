<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\dcvms;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Jumbojett\OpenIDConnectClient;
use DarthSoup\WhmcsApi\Client;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\Shared\ZipArchive;
use Laravel\Socialite\Facades\Socialite;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;
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
    // $templateProcessor = new TemplateProcessor('template.docx');
    // // $templateProcessor->setValue('firstname', 'John');
    // $values = [
    //     ['no' => 1, 'Jenis' => 'Batman', 'des' => 'Gotham City', 'seri' => 'Gotham City'],
    //     ['no' => 2, 'Jenis' => 'Batman', 'des' => 'Gotham City', 'seri' => 'Gotham City'],
    //     ['no' => 3, 'Jenis' => 'Batman', 'des' => 'Gotham City', 'seri' => 'Gotham City'],
    //     ['no' => 4, 'Jenis' => 'Batman', 'des' => 'Gotham City', 'seri' => 'Gotham City'],
    // ];
    // $templateProcessor->setImageValue('ttd', 'i.png');
    // $templateProcessor->cloneRowAndSetValues('no', $values);
    // $pathToSave = 'tes.docx';
    // $templateProcessor->saveAs($pathToSave);
    //Load temp file
});


Route::get('/whmcs',function(){
    // return dcvms::syncNow(1);
    return dcvms::syncNowAll();
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
