<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
{
    $this->middleware('employer.auth');
    // Instead of $this->middleware(RedirectIfNotEmployer::class);
}
    
//     // app/Http/Controllers/TaskController.php
// public function show(Task $task)
// {
//     \Log::debug('TaskController show method', [
//         'authenticated_employer' => auth()->guard('employer')->user(),
//         'task_owner' => $task->matricul_employer
//     ]);
    
//     // Verify task belongs to logged-in employer
//     if ($task->matricul_employer != auth()->guard('employer')->user()->matricul_employer) {
//         abort(403, 'Unauthorized action.');
//     }

//     return view('tasks.show', compact('task'));
// }

//     public function update(Request $request, Task $task)
//     {
//         $request->validate([
//             'status' => 'required|in:pending,in_progress,completed'
//         ]);

//         $task->update(['status' => $request->status]);

//         return redirect()->route('tasks.show', $task)
//                ->with('success', 'Task status updated successfully!');
//     }
}