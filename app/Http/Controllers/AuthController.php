<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericProvider;

class AuthController extends Controller
{
    public function redirectToProvider()
    {
        // Konfigurasi OAuth2 Provider untuk WHMCS
        $provider = new GenericProvider([
            'clientId'     => 'PT-SEMUT-DATA-IN.4c6d0b56064e2a63fa10657fff829fa4',
            'clientSecret' => 'nFd3xAKPhaJ3fWh8Xf496uqv42wk3fPdlCf1OXUAIYgyFFdPa1JjeHZ95YwpZw36QzwSjs9St2+CSc/vzw0I+A==',
            'redirectUri'  => 'https://maulanasopian.my.id/auth/whmcs/callback',
            'urlAuthorize' => 'https://devmy.antmedia.id/oauth/authorize.php',
            'urlAccessToken' => 'https://devmy.antmedia.id/oauth/token.php',
            'urlResourceOwnerDetails' => 'https://devmy.antmedia.id/oauth/',
            'scopes' => ['openid'], // Sesuaikan dengan scope yang diperlukan
        ]);

        // Redirect ke halaman otentikasi WHMCS
        return redirect($provider->getAuthorizationUrl());
    }

    public function handleProviderCallback()
    {
        $provider = new GenericProvider([
            'clientId'     => 'PT-SEMUT-DATA-IN.4c6d0b56064e2a63fa10657fff829fa4',
            'clientSecret' => 'nFd3xAKPhaJ3fWh8Xf496uqv42wk3fPdlCf1OXUAIYgyFFdPa1JjeHZ95YwpZw36QzwSjs9St2+CSc/vzw0I+A==',
            'redirectUri'  => 'https://maulanasopian.my.id/auth/whmcs/callback',
            'urlAuthorize' => 'https://devmy.antmedia.id/oauth/authorize.php',
            'urlAccessToken' => 'https://devmy.antmedia.id/oauth/token.php',
            'issuer' => 'https://maulanasopian.my.id',
            'urlResourceOwnerDetails' => '',
            'scopes' => ['openid'], // Sesuaikan dengan scope yang diperlukan
        ]);

        try {
            // Dapatkan token akses dengan kode yang diberikan oleh WHMCS
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $request->input('code'),
            ]);

            // Dapatkan informasi pengguna dari WHMCS
            $resourceOwner = $provider->getResourceOwner($token);

            // Lakukan apa yang perlu dilakukan setelah berhasil otentikasi
            // Contoh: Login pengguna atau simpan informasi pengguna ke dalam database

            // Redirect ke halaman setelah otentikasi berhasil
            return redirect()->route('home');
        } catch (IdentityProviderException $e) {
            // Tangani kesalahan jika otentikasi gagal
            return redirect()->route('login')->with('error', 'Otentikasi WHMCS gagal: ' . $e->getMessage());
        }
    }
}
