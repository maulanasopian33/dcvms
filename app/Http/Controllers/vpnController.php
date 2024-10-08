<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\RouterOSAPI;
use App\Models\vpn;
use Illuminate\Support\Facades\Validator;

class vpnController extends Controller
{
    function getall(){
        self::syncAll();
        sleep(1000);
        $vpnData = vpn::all();
        return response()->json([
            'status' => true,
            // 'data'   => $vpnData
            'data'   => RSAClass::encrypt(json_encode($vpnData))
        ]);
    }
    function syncAll(){
        $API = new RouterOSAPI();
        if ($API->connect(env('router_ip'), env('api_username'), env('api_password'))) {
            $API->write('/ppp/secret/print');
            $vpnUsers = $API->read();
            $API->disconnect();
            return self::storetoDB($vpnUsers);
        } else {
            return response()->json([
                'status' => false,
                'data'  => "internal server error"
            ]);
        }
    }
    function storetoDB($data){
        foreach ($data as $key => $value) {
            $cek = vpn::where('vpnId',$value['.id'])->first();
            $db = new vpn();
            if($cek){
                $db = $cek;
            }
            try {
                $db->name = $value['name'];
                $db->disabled = $value['disabled'];
                $db->vpnId = $value['.id'];
                $db->localAddress = $value['local-address'];
                $db->remoteAddress = $value['remote-address'];
                $db->password = $value['password'];
                $db->save();
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'data'  => $th->getMessage(),
                    'message' => 'error menyimpan vpn'
                ]);
            }
        }
        return response()->json([
            'status' => true,
            'data'   => "berhasil melakukan sync data VPN"
        ]);
    }
    function getbyusername($id){

        $vpn = vpn::where('name',$id)->get();
        if(!$vpn){
            return response()->json([
                'status' => false,
                'message'=> 'tidak dapat mengambil data'
            ]);
        }
        return response()->json([
            'status' => true,
            'data'   =>RSAClass::encrypt(json_encode($vpn))
        ]);
    }
    function disable(Request $req){
        if($req->status === 'disable'){
            if (!$this->setdisable($req->username)) {
                return response()->json([
                    'status' => false,
                    'message'=> 'Tidak dapat terhubung ke Router'
                ]);
            }
            self::syncAll();
            return response()->json([
                'status' => true,
                'message'=> $req->name.' berhasil diubah menjadi disable'
            ]);
        }
        if($req->status === 'enable'){
            if (!$this->setenable($req->username)) {
                return response()->json([
                    'status' => false,
                    'message'=> 'Tidak dapat terhubung ke Router'
                ]);
            }
            self::syncAll();
            return response()->json([
                'status' => true,
                'message'=> $req->name.' berhasil diubah menjadi enable'
            ]);
        }
    }

    function setdisable($username){
        $API = new RouterosAPI();
        if ($API->connect(env('router_ip'), env('api_username'), env('api_password'))) {
            $API->write('/ppp/secret/disable', false);
            $API->write('=numbers=' . $username);
            $result = $API->read();
            $API->disconnect();

            return true;
        } else {
            return false;
        }
    }
    function setenable($username){
        $API = new RouterosAPI();
        if ($API->connect(env('router_ip'), env('api_username'), env('api_password'))) {
            $API->write('/ppp/secret/enable', false);
            $API->write('=numbers=' . $username);
            $result = $API->read();
            $API->disconnect();

            return true;
        } else {
            return false;
        }
    }
    function configvpn(Request $req){
        $API = new RouterosAPI();
        if ($API->connect(env('router_ip'), env('api_username'), env('api_password'))) {
            $API->write('/ppp/secret/set', false);
            $API->write('=.id=' . $req->username, false);
            $API->write('=password=' . $req->Password);
            $result = $API->read();
            $API->disconnect();

            return response()->json([
                'status' => true,
                'message'=> $req->name.' berhasil diupdate'
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message'=> $req->name.' tidak berhasil diupdate'
            ]);
        }
    }
    function createvpn(Request $req){
        $validate = Validator::make($req->all(),[
            'local' => 'required',
            'password' => 'required',
            'remote' => 'required',
            'repassword' => 'required',
            'username' => 'required'
        ]);
        if($validate->fails()){
            return response()->json([
                'status'    => false,
                'message'   => 'silahkan coba kembali',
                'err'     => $validate->errors()
            ]);
        }

        $API = new RouterosAPI();

        // Koneksi ke MikroTik
        if ($API->connect(env('router_ip'), env('api_username'), env('api_password'))) {
            $API->write('/ppp/secret/add', false);
            $API->write('=name=' . $req->username, false);
            $API->write('=password=' . $req->password, false);
            $API->write('=remote-address=' . $req->remote, false);
            $API->write('=local-address=' . $req->local);
            $result = $API->read();
            $API->disconnect();

            return response()->json([
                'status'    => true,
                'message'   => 'Berhasil menambahkan vpn',
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'tidak berhasil menambahkan vpn',
            ]);
        }

    }
    function destroy(Request $req){
        $API = new RouterosAPI();
        if ($API->connect(env('router_ip'), env('api_username'), env('api_password'))) {
            // Menghapus pengguna VPN
            $API->write('/ppp/secret/remove', false);
            $API->write('=numbers=' . $req->username);
            $result = $API->read();
            $API->disconnect();

            return response()->json([
                'status' => true,
                'message'=> $req->name.' berhasil dihapus'
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message'=> $req->name.' tidak berhasil dihapus'
            ]);
        }
    }
}
