<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FallbackHandler
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->getHost() === env('FALLBACK_HOST')) {
            config(['database.connections.tenant'] , [
                'driver' => 'mysql',
                'host' => env('DB_HOST', '127.0.0.1'),
                'port' => env('DB_PORT', '3306'),
                'database' => env('DB_DATABASE', 'tenancycom'),
                'username' => env('DB_USERNAME', 'root'),
                'password' => env('DB_PASSWORD', '1234'),
                'unix_socket' => env('DB_SOCKET', ''),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ]);
        }    
    
        return $next($request);
    }
}