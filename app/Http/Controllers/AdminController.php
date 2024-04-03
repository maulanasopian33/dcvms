<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Ilovepdf\OfficepdfTask;
use App\Utils\ReCaptchaVerifier;
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

        $secret = env('secretKey');
        $url = env('urlVerify');

        $response = Http::post($url, [
            'secret' => $secret,
            'response' => $req->token,
        ]);
        if(!$response->successful()){
            return response()->json([
                'status'    => false,
                'message'   => 'Login gagal silahkan coba kembali',
                'err'     => $response->json()
            ]);
        }
        $login = admin::where('username',$req->username)->first();
        if(!$login){
            return response()->json([
                'status'    => false,
                'message'   => "Username tidak ditemukan"
            ]);
        }
        if(password_verify($req->password,$login->password)){
            $token = $login->createToken('admin token',['admin'])->accessToken;
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
    public function getall(){
        return response()->json([
            "status" => true,
            "message"=> "getdata",
            "data"   => Admin::all()
        ]);
    }

    public function addadmin(Request $req){
        $validate = Validator::make($req->all(),[
            'username' => 'required',
            'fullname' => 'required',
            'email'    => 'required',
            'password' => 'required'
        ]);
        if($validate->fails()){
            return response()->json([
                'status'    => false,
                'message'   => 'gagal menyimpan data',
                'err'     => $validate->errors()
            ]);
        }
        try {
            $data = [
                "fullname"  => $req->fullname,
                "username"  => $req->username,
                "email"     => $req->email,
                "password"  => bcrypt($req->password)
            ];
            $save = admin::create($data);

            if($save){
                return response()->json([
                    "status" => true,
                    "message"=> "Berhasil menyimpan data",
                    "data"   => $save
                ]);
            }else{
                return response()->json([
                    "status" => false,
                    "message"=> "Gagal menyimpan data, coba lagi",
                    "data"   => $data
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message"=> "Gagal menyimpan data, coba lagi",
                "data"   => $th
            ]);
        }
    }
    public function destroy($uid)
    {
        try {
            $data = Admin::findOrFail($uid);
            $data->delete();
            return response()->json([
                "status" => true,
                "message"=> "Berhasil Menghapus Data admin "

            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message"=> "Gagal Menghapus",
                "error"=> $th

            ]);
        }
    }

    public function setAssignVPN(Request $req){
        $validate = Validator::make($req->all(),[
            'usernameVPN'   => 'required',
            'usernameUser'  => 'required',
            'setNull'       => 'required'
        ]);
        if($validate->fails()){
            return response()->json([
                'status'    => false,
                'message'   => 'silahkan coba kembali',
                'err'     => $validate->errors()
            ]);
        }
        $user = User::where('name',$req->usernameUser)->first();
        $assignvpn = '';
        if(!$req->setNull){
            $assignvpn = $req->usernameVPN;
        }
        $user->update([
            'vpn' => $assignvpn
        ]);
        return response()->json([
            'status'    => true,
            'message'   => 'berhasil mengupdate data'
        ]);
    }
}
