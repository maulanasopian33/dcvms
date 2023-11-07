<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ScopeCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,...$scopes): Response
    {
        foreach ($scopes as $scope) {
            if (! $request->user() || ! $request->user()->tokenCan($scope)) {
                // abort(403, 'Insufficient scope.');
                return response()->json([
                    "status" => false,
                    "message"=> "Anda tidak di izinkan untuk mengakses ini"
                ]);
            }
        }
        return $next($request);
    }
}
