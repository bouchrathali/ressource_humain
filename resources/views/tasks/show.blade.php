<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hover-scale { transition: transform 0.3s ease; }
        .hover-scale:hover { transform: scale(1.02); }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 min-h-screen">

  <div class="flex flex-col h-screen">
        <!-- Navigation -->
        <nav class="bg-blue-900 text-white p-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <span class="text-2xl font-bold">Employer Dashboard</span>
        <div class="flex space-x-4">
            <a href="{{ route('employer.profile') }}" 
               class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded-lg">
                Profile
            </a>
            <a href="{{ route('employer.logout') }}" 
               class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg">
                Logout
            </a>
        </div>
    </div>
</nav>

    <!-- Task Content -->
    <div class="flex-grow container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-3xl mx-auto hover-scale">
            <!-- Task title and current status -->
            <div class="flex justify-between items-start mb-6">
                <h1 class="text-3xl font-bold">{{ $task->title }}</h1>
                <span id="statusBadge" class="px-4 py-2 text-sm rounded-full task-status
                    {{ $task->status == 'completed' ? 'bg-green-100 text-green-800' : 
                       ($task->status == 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                </span>
            </div>
            
            <!-- Status Update Form -->
            <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-xl font-semibold">Update Task Status</h2>
                    <a href="{{ route('employer.dashboard') }}" 
                   class="bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded-lg hover-scale">
                    Back to Dashboard
                </a>
                </div>
                <form id="statusForm" action="{{ route('employer.task.update-status', $task->id) }}" method="POST">
                    @csrf
                    <div class="flex items-center space-x-4">
                        <select name="status" id="statusSelect" class="border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg hover-scale transition-colors duration-300">
                            Update Status
                        </button>
                    </div>
                </form>
                
                <div id="flashMessageContainer">
                    @if(session('success'))
                        <div class="mt-3 p-3 bg-green-100 text-green-800 rounded-lg flash-message">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="mt-3 p-3 bg-red-100 text-red-800 rounded-lg flash-message">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Task details -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2">Description</h2>
                <p class="text-gray-700 whitespace-pre-line">{{ $task->description }}</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h2 class="text-xl font-semibold mb-2">Due Date</h2>
                    <p class="text-gray-700">{{ $task->due_date->format('F j, Y') }}</p>
                </div>
                <div>
                    <h2 class="text-xl font-semibold mb-2">Created At</h2>
                    <p class="text-gray-700">{{ $task->created_at->format('F j, Y') }}</p>
                </div>
            </div>
            
            @if($task->file_path)
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2">Attachments</h2>
                <a href="{{ Storage::url($task->file_path) }}" 
                   target="_blank" 
                   class="text-blue-600 hover:underline flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    Download Attachment
                </a>
            </div>
            @endif
        </div>
    </div>
</div><script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    // Initialize Echo
    const echo = new Echo({
        broadcaster: 'pusher',
        key: '{{ config('broadcasting.connections.pusher.key') }}',
        cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
        encrypted: true
    });

    // Listen for updates
    echo.channel('employer.tasks.{{ $task->matricul_employer }}')
        .listen('TaskStatusUpdated', (data) => {
            updateTaskStatusDisplay(data.task);
        });

    function updateTaskStatusDisplay(task) {
        // Update status badge
        const statusBadge = document.getElementById('statusBadge');
        if (statusBadge) {
            const statusText = task.status.replace('_', ' ');
            statusBadge.textContent = statusText.charAt(0).toUpperCase() + statusText.slice(1);
            statusBadge.className = `px-4 py-2 text-sm rounded-full ${
                task.status === 'completed' ? 'bg-green-100 text-green-800' : 
                (task.status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')
            }`;
        }

        // Update select dropdown
        const statusSelect = document.getElementById('statusSelect');
        if (statusSelect) {
            statusSelect.value = task.status;
        }
    }
</script>
</body>
</html>