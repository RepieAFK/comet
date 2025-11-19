<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ConflictMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Tambahkan log untuk debugging
        \Log::info('Conflict Middleware: Checking for conflicts');
        
        return $next($request);
    }
}