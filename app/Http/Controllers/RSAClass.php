<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use phpseclib\Crypt\RSA;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Illuminate\Support\Facades\Crypt;

class RSAClass extends Controller
{
    public function createKey(){
        $newKey = Key::createNewRandomKey();
        $asciiSafeKey = $newKey->saveToAsciiSafeString();
        Storage::put('PKE.pem',$asciiSafeKey);
        return response()->json([
            'status' => true,
            'data'   => $asciiSafeKey
        ]);
    }

    static public function encrypt($data){
            $passphrase= Storage::get('PKE.pem');
            $salt = openssl_random_pseudo_bytes(8);
            $salted = '';
            $dx = '';
            while (strlen($salted) < 48) {
                $dx = md5($dx.$passphrase.$salt, true);
                $salted .= $dx;
            }
            $key = substr($salted, 0, 32);
            $iv  = substr($salted, 32,16);
            $encrypted_data = openssl_encrypt(json_encode($data), 'aes-256-cbc', $key, true, $iv);
            $data = array("ct" => base64_encode($encrypted_data), "iv" => bin2hex($iv), "s" => bin2hex($salt));
            return base64_encode(json_encode($data));
    }
}
