@extends('layouts.app')

@section('content')
    <div class="p-6">
        <h2 class="text-2xl font-semibold">Welcome to the Dashboard</h2>
        <p class="mt-4 text-gray-700">This is the employer's home page.</p>

        <!-- Example content -->
        <div class="mt-6 bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium">Recent Activities</h3>
            <ul class="mt-2 space-y-2">
                <li class="p-3 bg-gray-100 rounded-lg">✔ Task 1 completed successfully</li>
                <li class="p-3 bg-gray-100 rounded-lg">📌 New announcement posted</li>
                <li class="p-3 bg-gray-100 rounded-lg">💼 Meeting scheduled for Monday</li>
            </ul>
        </div>
    </div>
@endsection5