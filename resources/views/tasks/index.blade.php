@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">My Tasks</h1>
        <a href="{{ route('employer.dashboard') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
            Back to Dashboard
        </a>
    </div>

    <div class="space-y-4">
        @foreach($tasks as $task)
        <a href="{{ route('employer.tasks.show', $task->id) }}" 
           class="block p-4 border rounded-lg hover:shadow-md transition">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="font-semibold">{{ $task->title }}</h3>
                    <p class="text-sm text-gray-600">Due: {{ $task->due_date->format('M d, Y') }}</p>
                </div>
                <div>
                    <span class="px-2 py-1 text-xs rounded-full 
                        @if($task->status == 'completed') bg-green-100 text-green-800
                        @elseif($task->status == 'in_progress') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                    </span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection