<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Manager;
use App\Models\LeaveRequest; // Assuming you have this model

class ManagerController extends Controller
{
    /**
     * Display the manager dashboard
     */ public function showLoginForm()
    {
        return view('manager');  // This is where you show the manager login page
    }
    public function dashboard()
    {
        // Get the authenticated manager
        $manager = Auth::guard('manager')->user();
        
        // Get pending leave requests (assuming you have this relationship)
        $pendingLeaves = LeaveRequest::where('status', 'pending')->get();
        
        return view('manager', [
            'dashboard' => true,
            'manager' => $manager,
            'pendingLeaves' => $pendingLeaves
        ]);
    }

    /**
     * Handle manager login (GET and POST)
     */
    public function login(Request $request)
    {
        // If GET request, show login form
        if ($request->isMethod('get')) {
            return view('manager', ['dashboard' => false]);
        }
        
        // POST request - validate credentials
        $credentials = $request->validate([
            'matricul_manager' => 'required|string',
            'password' => 'required|string'
        ]);
        
        // Attempt authentication
        if (Auth::guard('manager')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('manager.dashboard');
        }
        
        // Failed login
        return back()->withErrors([
            'matricul_manager' => 'The provided credentials do not match our records.',
        ])->onlyInput('matricul_manager');
    }

    /**
     * Handle manager logout
     */
    public function logout(Request $request)
{
    Auth::guard('manager')->logout();
    
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    return redirect()->route('manager.login');
}

    public function showProfile()
{
    return view('mangerprofile', [
        'manager' => Auth::guard('manager')->user()
    ]);
}
}