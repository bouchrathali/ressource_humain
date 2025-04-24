<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployerAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->guard('employer')->check()) {
            return redirect()->route('employer');
        }
    
        return $next($request);
    }

    public function authenticate(Request $request)
{
    $credentials = $request->validate([
        'matricule' => 'required|string',
        'password' => 'required|string',
    ]);

    if (auth()->guard('employer')->attempt([
        'matricul_employer' => $credentials['matricule'],
        'password' => $credentials['password']
    ])) {
        // Authentication passed...
        return redirect()->route('employer.dashboard');
    }

    return back()->withErrors([
        'error' => 'Invalid credentials',
    ]);
}
}
