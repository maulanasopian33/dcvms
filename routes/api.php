<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\dcvms;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductdetailController;
use App\Http\Controllers\RSAClass;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\VisitDcController;
use App\Http\Controllers\vpnController;
use App\Models\admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/en',function(){
    return RSAClass::encrypt('dasjdhakshdkjajshjkdhasjkhdjkashdkjashdjkjh');
});
Route::middleware(['auth:admin','checkscope:admin'])->group(function(){
    Route::get('/test',function(){
        return 'hhhh';
    });
});
Route::get('/get', function(){
    $users = admin::where('username','sopian')->first();
    $user = admin::find($users->id);
    // return $user;
    $token = $user->createToken('API Token',['admin'])->accessToken;
    return $token;
});
Route::get('/surat/getbyNomor/{id}',[SuratController::class,'getbyNomor']);
Route::post('/request/visit', [dcvms::class, 'sendemailrequest']);
Route::get('/getUser/{id}', [Controller::class,'getUser']);
Route::get('/product',[ProductController::class,"getdatalimit"]);
Route::post('/teams',[TeamsController::class,'store']);
Route::put('/teams',[TeamsController::class,'update']);
Route::get('/teams/{id}',[TeamsController::class,'index']);
Route::post('/teams/delete/{uid}',[TeamsController::class,'destroy']);
Route::get('/teams/getbyname/{id}/{data}',[TeamsController::class,'getbyname']);
Route::post('/visitdc',[VisitDcController::class,'store']);
Route::post('/request/guest/visitdc',[VisitDcController::class,'guestrequest']);
Route::post('/visitdc/delete/{uid}',[VisitDcController::class,'destroy']);
Route::get('/visitdc/{id}',[VisitDcController::class,'index']);
Route::get('/visitdc/report/{uid}',[VisitDcController::class,'getbyUID']);
Route::get('/produk/detail/{visitid}',[ProductdetailController::class, 'getbyVisitId']);
Route::get('/produk/detail/produkid/{id}',[ProductdetailController::class, 'getbyproductId']);
Route::get('/get/vpn/{id}',[vpnController::class, 'getbyusername']);
Route::get('/create/rsaClient', [RSAClass::class,'createKey']);
Route::post('/vpn/disable',[vpnController::class, 'disable']);

Route::get('/sync/{id}',function($id){
    return dcvms::syncNow($id);
});
Route::get('/sync',function(){
    return dcvms::syncNowAll();
});
// admin route
Route::post('/admin/login',[AdminController::class, 'login']);
Route::middleware(['auth:admin','checkscope:admin'])->group(function(){
    Route::post('/admin/vpn/assign',[AdminController::class, 'setAssignVPN']);
    Route::post('/admin/vpn/create',[vpnController::class, 'createvpn']);
    Route::post('/admin/vpn/disable',[vpnController::class, 'disable']);
    Route::post('/admin/vpn/delete',[vpnController::class, 'destroy']);
    Route::post('/admin/vpn/change',[vpnController::class, 'configvpn']);
    Route::get('/admin/getUser', [Controller::class,'getalluser']);
    Route::get('/admin/vpn',[vpnController::class, 'getall']);
    Route::get('/admin/getdata',[AdminController::class,'getdata']);
    Route::get('/create/rsa', [RSAClass::class,'createKey']);
    Route::post('/admin/user',[AdminController::class,'addadmin']);
    Route::post('/admin/user/delete/{uid}',[AdminController::class,'destroy']);
    Route::get('/admin/getalluser',[AdminController::class,'getall']);
    Route::get('/visitdc',[VisitDcController::class,'getall']);
    Route::put('/visitdc/update',[VisitDcController::class,'update']);
    Route::get('/admin/visitdc/{uid}',[VisitDcController::class,'getbyUID']);
    Route::post('/admin/surat/',[SuratController::class,'create']);
    Route::put('/admin/surat/update',[SuratController::class,'update']);
    Route::get('/admin/surat/{id}',[SuratController::class,'getdata']);
    Route::post('admin/surat/i/{id}',[SuratController::class,'suratmasuk']);
    Route::post('admin/surat/unloading/{id}',[SuratController::class,'suratkeluar']);
});
Route::put('/admin/productdetail/{id}',[ProductdetailController::class,"update"]);

