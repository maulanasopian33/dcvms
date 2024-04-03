namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ReCaptchaVerifier
{
    public static function verifyToken($token)
    {
        $secret = env('secretKey');
        $url = env('urlVerify');
        
        $response = Http::post($url, [
            'secret' => $secret,
            'response' => $token,
        ]);

        if ($response->successful()) {
            return true; // Token valid
        } else {
            return false; // Token tidak valid
        }
    }
}
