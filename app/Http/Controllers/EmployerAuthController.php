<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployerAuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'matricule' => 'required|string',
            'password' => 'required|string',
        ]);

        $employer = DB::table('employers')
                    ->where('matricul_employer', $credentials['matricule'])
                    ->first();

        if ($employer && Hash::check($credentials['password'], $employer->passwordE)) {
            session([
                'employer_authenticated' => true,
                'employer_data' => $employer
            ]);
            
            return redirect()->route('employer.dashboard');
        }

        return back()->withErrors([
            'error' => 'Invalid matricule or password',
        ]);
    }

    public function logout(Request $request)
    {
        $request->session()->forget([
            'employer_authenticated',
            'employer_data'
        ]);
        
        return redirect()->route('employer');
    }
}