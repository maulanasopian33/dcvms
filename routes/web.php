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
    // $pathToSave = 'tes.pdf';
    // $templateProcessor->saveAs($pathToSave);
});

Route::get('/pdf', function(){
    return 'test';
    $myTask = new OfficepdfTask('project_public_4700007d28979563a8f4be0ef0dd878a_HpDRz9c49a43d172dddde64870caed23d9890','secret_key_98330738ab0daf2235f454ef2e9565cb_heiZwc069a97ae69d12007552f9c88be6c10c');

// // file var keeps info about server file id, name...
// // it can be used latter to cancel file
// $file = $myTask->addFile('tes.docx');

// // process files
// $myTask->execute();

// // and finally download file. If no path is set, it will be downloaded on current folder
$myTask->download();
})->middleware(['pdflimit']);
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

Route::get('/tes', function(){
    return response()->json(surat::with('product.productdetail')->where('id','1')->get());
});
