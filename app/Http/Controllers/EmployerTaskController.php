<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployerTaskController extends Controller
{
    // app/Http/Controllers/EmployerTaskController.php
public function index()
{
    $employer = session('employer_data');
    $tasks = Task::where('matricul_employer', $employer->matricul_employer)
                ->orderBy('due_date')
                ->get();
                
    return view('tasks.index', ['tasks' => $tasks]);
}

public function show(Task $task)
{
    return view('tasks.show', ['task' => $task]);
}
}
