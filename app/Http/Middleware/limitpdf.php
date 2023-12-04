<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class limitpdf
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = "key"; // Key untuk identifikasi permintaan

        if ($this->limiter->tooManyAttempts($key, 7)) {
            return new Response('Terlalu banyak permintaan.', 429); // Kode status 429 untuk batasan terlampaui
        }
        $this->limiter->hit($key, 86400);
        return $next($request);
    }
}
