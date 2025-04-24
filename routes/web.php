<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployerAuthController;
use App\Http\Controllers\EmployerDashboardController;
use App\Http\Controllers\ManagerController;

use App\Http\Controllers\TaskController;
use App\Http\Controllers\RedirectIfNotEmployer;

Route::get('/', function () {
    return view('welcome');
});

// Employer Routes
Route::prefix('employer')->group(function () {
    // Show login form
    Route::get('/', function () {
        return view('employer');
    })->name('employer');
    
    // Handle login
    Route::post('/authenticate', [EmployerAuthController::class, 'authenticate'])
        ->name('employer.authenticate');
    
    // Dashboard (protected)
    Route::get('/dashboard', function () {
        if (!session('employer_authenticated')) {
            return redirect()->route('employer');
        }
        
        return view('employer', [
            'dashboard' => true,
            'employer' => session('employer_data') // Already stored as object
        ]);
    })->name('employer.dashboard');
    
    // Logout
    Route::get('/logout', [EmployerAuthController::class, 'logout'])
        ->name('employer.logout');
      
        
        Route::get('/profile', function () {
            if (!session('employer_authenticated')) {
                return redirect()->route('employer');
            }
            
            return view('profile', [
                'employer' => session('employer_data')
            ]);
        })->name('employer.profile');


        // Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
        // Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');

        Route::get('/employer/tasks/{id}', [EmployerDashboardController::class, 'showTask'])->name('employer.task.show');
          Route::get('/employer/dashboard', [EmployerDashboardController::class, 'index'])
     ->name('employer.dashboard');
     Route::post('/employer/tasks/{id}/update-status', [EmployerDashboardController::class, 'updateTaskStatus'])
     ->name('employer.task.update-status');


     Route::post('/employer/presence', [EmployerDashboardController::class, 'recordPresence'])
    ->name('employer.presence.record');

Route::get('/employer/presence/history', [EmployerDashboardController::class, 'getPresenceHistory'])
    ->name('employer.presence.history');

   
    Route::post('/leave-request', [EmployerDashboardController::class, 'submitLeaveRequest'])
    ->name('employer.leave.request.submit'); // Changed route name

Route::get('/leave-requests', [EmployerDashboardController::class, 'getLeaveRequests'])
    ->name('employer.leave.requests');




    Route::post('/presence/record', [EmployerDashboardController::class, 'recordPresence'])
    ->name('presence.record');
});

Route::middleware(['auth', 'manager'])->prefix('manager')->group(function () {
    Route::get('/leave-approvals', [LeaveManageController::class, 'index'])
        ->name('leave.approvals');
    Route::put('/leave-approvals/{id}', [LeaveManageController::class, 'update'])
        ->name('leave.approvals.update');
    
    // Remove this duplicate route:
    // Route::post('/leave-request', [EmployerDashboardController::class, 'submitLeaveRequest'])
    //    ->name('leave.request.submit');
});






















































// Manager routes
Route::prefix('manager')->name('manager.')->group(function () {
    // Show login form
    Route::get('login', [ManagerController::class, 'showLoginForm'])->name('login');
    
    // Handle login submission
    Route::post('login', [ManagerController::class, 'login'])->name('login.submit');
    
    // Authenticated routes
    Route::middleware(['auth:manager'])->group(function () {
        Route::get('dashboard', [ManagerController::class, 'dashboard'])->name('dashboard');
        
        // Add profile route
        Route::get('profile', [ManagerController::class, 'showProfile'])->name('profile');
        
        Route::post('logout', [ManagerController::class, 'logout'])->name('logout');
        
        // Leave approval routes
        Route::get('leave-approvals', [LeaveManageController::class, 'index'])->name('leave.approvals');
        Route::put('leave-approvals/{id}', [LeaveManageController::class, 'update'])->name('leave.approvals.update');
    });
});