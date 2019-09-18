<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Config;
class EnforceSystem
{
    public function handle($request, Closure $next)
    {
        Config::set('database.default', 'system');
        return $next($request);
    }
}