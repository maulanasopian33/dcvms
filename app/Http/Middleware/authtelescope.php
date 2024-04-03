<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

class authtelescope
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        $ipAddress = $request->ip();
        $code = $request->code;
        $allowedIP = explode(',', env('ALLOWED_IP'));
        if(in_array($ipAddress, $allowedIP) || $code === "antcode"){
            return  $next($request);
        }
        return $next($request);
        // return Telescope::check($request) ? $next($request) : abort(403);
    }
}
