<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveManageController extends Controller
{
    // View all requests for approval
    public function dashboard()
{
    $manager = auth('manager')->user();
    
    $pendingLeaves = LeaveRequest::with(['employee' => function($query) {
            $query->select('matricule', 'prenom', 'nom', 'position');
        }])
        ->where('status', 'pending')
        ->get();

    return view('manager.dashboard', [
        'manager' => $manager,
        'upcomingLeaves' => $pendingLeaves, // Rename to match your view
        'pendingLeavesCount' => $pendingLeaves->count()
    ]);
}

    // Approve/Reject request
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'manager_comment' => 'nullable|string|max:500'
        ]);

        $leave = LeaveRequest::findOrFail($id);
        $leave->update([
            'status' => $validated['status'],
            'manager_comment' => $validated['manager_comment'],
            'approved_at' => $validated['status'] == 'approved' ? now() : null
        ]);

        return back()->with('success', 'Request updated!');
    }

    public function upcomingLeaves()
{
    $upcomingLeaves = LeaveRequest::with(['employee' => function($query) {
            $query->select('id', 'prenom', 'nom', 'position');
        }])
        ->where('status', 'pending')
        ->orWhere(function($query) {
            $query->where('status', 'approved')
                  ->where('start_date', '>=', now());
        })
        ->orderBy('start_date')
        ->paginate(10);

    return view('manager.profile', [
        'upcomingLeaves' => $upcomingLeaves,
        'pendingLeavesCount' => LeaveRequest::where('status', 'pending')->count()
    ]);
}
}