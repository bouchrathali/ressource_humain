<?php
namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    // Submit new leave request
    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|in:vacation,sick,personal,other',
            'reason' => 'required|string|min:10'
        ]);

        LeaveRequest::create([
            'matricul_employer' => auth()->user()->matricul_employer,
            'matricul_manager' => auth()->user()->manager_id, // Assuming employees have manager_id
            ...$validated,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Leave request submitted!');
    }

    // View employee's own requests
    public function index()
    {
        $requests = LeaveRequest::where('matricul_employer', auth()->user()->matricul_employer)
                              ->orderBy('created_at', 'desc')
                              ->get();

        return view('employer', compact('requests'));
    }
}