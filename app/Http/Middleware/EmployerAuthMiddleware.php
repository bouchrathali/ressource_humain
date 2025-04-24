<?php
// app/Http/Middleware/EmployerAuthMiddleware.php
namespace App\Http\Middleware;

use Closure;

class EmployerAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!session('employer_authenticated')) {
            return redirect()->route('employer');
        }
        
        return $next($request);
    }
}