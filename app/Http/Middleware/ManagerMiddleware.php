<?php
// app/Http/Middleware/ManagerMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ManagerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'Manager') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Unauthorized access');
    }
}