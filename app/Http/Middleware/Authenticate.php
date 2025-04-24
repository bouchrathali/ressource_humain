<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->is('manager/*')) {
            return route('manager.login.show'); // Redirect to manager login page
        }

        if ($request->is('employer/*')) {
            return route('employer.login.show'); // Redirect employers to their login
        }

        return route('login'); // Default for other guards (like web)
    }
}
