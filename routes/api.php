<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\dcvms;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductdetailController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\VisitDcController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PhpOffice\PhpWord\TemplateProcessor;

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

Route::middleware(['auth:api','checkscope:admin'])->group(function(){
    Route::get('/test',function(){
        return 'hhhh';
    });
});
Route::get('/get', function(){
    $user = User::find(3);
    $token = $user->createToken('API Token',['admin'])->accessToken;
    return $token;
});

Route::get('/getUser/{id}', [Controller::class,'getUser']);
Route::get('/product',[ProductController::class,"getdatalimit"]);
Route::post('/teams',[TeamsController::class,'store']);
Route::put('/teams',[TeamsController::class,'update']);
Route::get('/teams/{id}',[TeamsController::class,'index']);
Route::post('/teams/delete/{uid}',[TeamsController::class,'destroy']);
Route::get('/teams/getbyname/{id}/{data}',[TeamsController::class,'getbyname']);
Route::post('/visitdc',[VisitDcController::class,'store']);
Route::post('/visitdc/delete/{uid}',[VisitDcController::class,'destroy']);
Route::get('/visitdc/{id}',[VisitDcController::class,'index']);
Route::get('/visitdc/report/{uid}',[VisitDcController::class,'getbyUID']);
Route::get('/produk/detail/{visitid}',[ProductdetailController::class, 'getbyVisitId']);
Route::get('/produk/detail/produkid/{id}',[ProductdetailController::class, 'getbyproductId']);
Route::get('/sync/{id}',function($id){
    return dcvms::syncNow($id);
});
Route::get('/sync',function(){
    return dcvms::syncNowAll();
});

// admin route
Route::post('/admin/login',[AdminController::class, 'login']);
Route::middleware(['auth:api','checkscope:admin'])->group(function(){
    Route::get('/admin/getdata',[AdminController::class,'getdata']);
    Route::get('/admin/getalluser',[AdminController::class,'getall']);
    Route::get('/visitdc',[VisitDcController::class,'getall']);
    Route::put('/visitdc/update',[VisitDcController::class,'update']);
});



