<?php

namespace App\Http\Controllers;

use App\Models\admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function login(Request $req){
        $validate = Validator::make($req->all(),[
            'username' => 'required',
            'password' => 'required'
        ]);
        if($validate->fails()){
            return response()->json([
                'status'    => false,
                'message'   => 'Login gagal silahkan coba kembali',
                'err'     => $validate->errors()
            ]);
        }
        $login = Admin::where('username',$req->username)->first();
        if(!$login){
            return response()->json([
                'status'    => false,
                'message'   => "Username tidak ditemukan"
            ]);
        }
        if(password_verify($req->password,$login->password)){
            $token = $login->createToken('API Token',['admin'])->accessToken;
            return response()->json([
                'status'    => true,
                'message'   => "berhasil login",
                'data'      => [
                    'token' => $token,
                    'userId'=> $login->id
                ]
            ]);
        }

        return response()->json([
            'status'    => false,
            'message'   => "Gagal login, periksa kembali username dan password"
        ]);
    }

    public function getdata(Request $req){
        $data = Admin::find($req->id);
        if($data){
            return response()->json([
                "status" => true,
                "message"=> "getdata",
                "data"   => $data
            ]);
        }
        return response()->json([
            "status" => false,
            "message"=> "Data User tidak ada",
            "data"   => $data
        ]);
    }
}
