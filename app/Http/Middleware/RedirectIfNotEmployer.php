<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotEmployer
{
   // app/Http/Middleware/RedirectIfNotEmployer.php
public function handle(Request $request, Closure $next)
{
    \Log::debug('Middleware check', [
        'authenticated' => auth()->guard('employer')->check(),
        'user' => auth()->guard('employer')->user()
    ]);
    
    if (!auth()->guard('employer')->check()) {
        \Log::debug('Redirecting to employer login');
        return redirect()->route('employer');
    }

    return $next($request);
}
}