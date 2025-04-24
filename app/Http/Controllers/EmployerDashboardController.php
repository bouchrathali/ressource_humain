<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // Add this line
use App\Models\LeaveRequest;
class EmployerDashboardController extends Controller
{
// app/Http/Controllers/EmployerDashboardController.php


public function index()
{
    if (!session('employer_authenticated')) {
        return redirect()->route('employer');
    }

    $employer = session('employer_data');
    
    $data = [
        'dashboard' => true,
        'employer' => $employer,
        'tasks' => Task::where('matricul_employer', $employer->matricul_employer)
                     ->orderBy('due_date')
                     ->get(),
        'todayPresence' => DB::table('presence')
                           ->where('matricule_employer', $employer->matricul_employer)
                           ->whereDate('date', Carbon::today())
                           ->first(),
        'presenceHistory' => DB::table('presence')
                             ->where('matricule_employer', $employer->matricul_employer)
                             ->orderBy('date', 'desc')
                             ->get(),
        'leaveRequests' => LeaveRequest::where('matricul_employer', $employer->matricul_employer)
                                    ->orderBy('created_at', 'desc')
                                    ->get()
    ];

    return view('employer', $data);
}
    
    public function recordPresence(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'arrive_time' => 'nullable|date_format:H:i',
            'leave_time' => 'nullable|date_format:H:i|after:arrive_time'
        ]);
    
        $employer = session('employer_data');
    
        DB::table('presence')->updateOrInsert(
            [
                'matricule_employer' => $employer->matricul_employer,
                'date' => $request->date
            ],
            [
                'arrive_time' => $request->arrive_time,
                'leave_time' => $request->leave_time,
                // Status is automatically managed (don't let user change it)
                'status' => $this->determineStatus($request->arrive_time, $request->leave_time)
            ]
        );
    
        return back()->with('success', 'Presence recorded successfully');
    }
    
    private function determineStatus($arriveTime, $leaveTime)
    {
        if (!$arriveTime && !$leaveTime) {
            return 'post_empty';
        } elseif ($arriveTime && !$leaveTime) {
            return 'at_work';
        } else {
            return 'on_vacation'; // Or any other status logic you need
        }
    }



    public function showTask($id)
    {
        if (!session('employer_authenticated')) {
            return redirect()->route('employer');
        }
    
        $employer = session('employer_data');
        $task = Task::where('id', $id)
                    ->where('matricul_employer', $employer->matricul_employer)
                    ->first();
    
        if (!$task) {
            abort(404, 'Task not found or you are not authorized to view it.');
        }
    
        return view('tasks.show', [
            'task' => $task,
            'employer' => $employer
        ]);
    }
    public function updateTaskStatus(Request $request, $id)
    {
        if (!session('employer_authenticated')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed'
        ]);
    
        $employer = session('employer_data');
        $task = Task::where('id', $id)
                  ->where('matricul_employer', $employer->matricul_employer)
                  ->firstOrFail();
    
                  $task->update(['status' => $validated['status']]);

                  if ($request->ajax()) {
                      return response()->json([
                          'success' => true,
                          'redirect' => route('employer.dashboard')
                      ]);
                  }
              
                  return redirect()->route('employer.dashboard')->with('success', 'Status updated!');
              
    }
// In EmployerDashboardController

 
public function clockIn(Request $request)
{
    if (!session('employer_authenticated')) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $employer = session('employer_data');
    $today = now()->toDateString();

    // Check if today's record exists
    $presence = Presence::firstOrCreate(
        ['matricul_employer' => $employer->matricul_employer, 'date_p' => $today],
        ['status' => 'At Work']
    );

    // Only update if not already set
    if (!$presence->time_arrive) {
        $presence->update(['time_arrive' => now()->toTimeString()]);
    }

    return response()->json([
        'success' => true,
        'time_arrive' => $presence->time_arrive
    ]);
}

public function clockOut(Request $request)
{
    if (!session('employer_authenticated')) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $employer = session('employer_data');
    $today = now()->toDateString();

    $presence = Presence::where('matricul_employer', $employer->matricul_employer)
        ->where('date_p', $today)
        ->firstOrFail();

    // Only update if not already set
    if (!$presence->time_leave) {
        $presence->update(['time_leave' => now()->toTimeString()]);
    }

    return response()->json([
        'success' => true,
        'time_leave' => $presence->time_leave
    ]);
}

public function getPresenceHistory()
{
    if (!session('employer_authenticated')) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $employer = session('employer_data');
    $history = Presence::where('matricul_employer', $employer->matricul_employer)
        ->orderBy('date_p', 'desc')
        ->get()
        ->map(function($record) {
            return [
                'date_p' => $record->date_p,
                'status' => $record->status,
                'time_arrive' => $record->time_arrive ? \Carbon\Carbon::parse($record->time_arrive)->format('H:i') : null,
                'time_leave' => $record->time_leave ? \Carbon\Carbon::parse($record->time_leave)->format('H:i') : null
            ];
        });

    return response()->json($history);
}public function getLeaveRequests()
{
    if (!session('employer_authenticated')) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $employer = session('employer_data');
    $requests = LeaveRequest::where('matricul_employer', $employer->matricul_employer)
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json($requests);
}

// In EmployerDashboardController
public function submitLeaveRequest(Request $request)
{
    $validated = $request->validate([
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after_or_equal:start_date',
        'type' => 'required|in:vacation,sick,personal,other',
        'reason' => 'required|string|min:10'
    ]);

    // Get the employee's manager (assuming relationship exists)
    $managerId = Employer::find(session('employer_data')->matricul_employer)
                       ->manager_id;

    LeaveRequest::create([
        'matricul_employer' => session('employer_data')->matricul_employer,
        'matricul_manager' => $managerId,
        'start_date' => $validated['start_date'],
        'end_date' => $validated['end_date'],
        'type' => $validated['type'],
        'reason' => $validated['reason'],
        'status' => 'pending'
    ]);

    return back()->with('success', 'Leave request submitted successfully!');
}

}