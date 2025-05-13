<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceHttpsIfNgrok
{
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();

        // Nếu đang truy cập qua ngrok
        if (str_contains($host, 'ngrok-free.app') || str_contains($host, 'ngrok.io')) {
            // Laravel sẽ render mọi asset(), url(), route() thành https://
            \URL::forceScheme('https');
        }

        return $next($request);
    }
}
