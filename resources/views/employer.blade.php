<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@isset($dashboard) Manager Dashboard @else Manager Authentication @endisset</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeIn 1s ease-out; }
        .hover-scale { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .hover-scale:hover { transform: scale(1.05); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); }
        
        .section-container {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
        }
        
        .section-header {
            border-bottom: 1px solid #e2e8f0;
            background-color: #f8fafc;
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
        }
        
        .history-table {
            background-color: white;
            border-radius: 0.5rem;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

@isset($dashboard)
    <!-- DASHBOARD VIEW -->
    <div class="flex flex-col h-screen">
        <!-- Navigation -->
        <nav class="bg-green-900 text-white p-4 shadow-md">
            <div class="container mx-auto flex justify-between items-center">
                <span class="text-2xl font-bold">Manager Dashboard</span>
                <div class="flex space-x-4">
                    <a href="{{ route('manager.profile') }}" 
                       class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded-lg">
                        Profile
                    </a>
                    <a href="{{ route('manager.logout') }}" 
                       class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg">
                        Logout
                    </a>
                </div>
            </div>
        </nav>

        <!-- Dashboard Content -->
        <div class="flex-grow container mx-auto p-6 space-y-6">
            <!-- Welcome Section -->
            <div class="section-container">
                <div class="p-6">
                    <h1 class="text-2xl font-bold text-gray-800">Welcome, {{ $manager->prenom }} {{ $manager->nom }}</h1>
                    <p class="text-gray-600">Department: {{ $manager->apartment }}</p>
                </div>
            </div>
            
            <!-- Pending Leave Requests Section -->
            <div class="section-container">
                <div class="section-header p-4">
                    <h2 class="text-xl font-bold text-gray-800">Pending Leave Requests</h2>
                </div>
                <div class="p-6">
                    @if($pendingLeaves->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($pendingLeaves as $leave)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $leave->employee->prenom }} {{ $leave->employee->nom }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $leave->start_date->format('M d, Y') }} - {{ $leave->end_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap capitalize">{{ $leave->type }}</td>
                                        <td class="px-6 py-4">{{ Str::limit($leave->reason, 50) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('leave.view', $leave->id) }}" 
                                                   class="text-blue-600 hover:text-blue-900">View</a>
                                                <form action="{{ route('leave.approve', $leave->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-900">Approve</button>
                                                </form>
                                                <button onclick="openRejectModal('{{ $leave->id }}')" 
                                                        class="text-red-600 hover:text-red-900">Reject</button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 py-4">No pending leave requests</p>
                    @endif
                </div>
            </div>

            <!-- Team Presence Overview -->
            <div class="section-container">
                <div class="section-header p-4">
                    <h2 class="text-xl font-bold text-gray-800">Team Presence Overview</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="font-semibold text-gray-700">Present Today</h3>
                            <p class="text-2xl font-bold text-green-600">{{ $presentCount }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="font-semibold text-gray-700">On Leave</h3>
                            <p class="text-2xl font-bold text-yellow-600">{{ $onLeaveCount }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="font-semibold text-gray-700">Absent</h3>
                            <p class="text-2xl font-bold text-red-600">{{ $absentCount }}</p>
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-semibold mt-6 mb-3 text-gray-800">Today's Status</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Arrival</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Departure</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($teamPresence as $presence)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $presence->employee->prenom }} {{ $presence->employee->nom }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            @if($presence->status == 'present') bg-green-100 text-green-800
                                            @elseif($presence->status == 'on_leave') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $presence->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $presence->arrive_time ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $presence->leave_time ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Task Management Section -->
            <div class="section-container">
                <div class="section-header p-4">
                    <h2 class="text-xl font-bold text-gray-800">Task Management</h2>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Your Tasks</h3>
                        <a href="{{ route('tasks.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                            New Task
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($tasks as $task)
                            <div class="p-4 border rounded-lg bg-white hover:shadow-lg transition-all duration-300 hover:border-green-300 hover-scale">
                                <h3 class="font-semibold text-lg text-gray-800">{{ $task->title }}</h3>
                                <p class="text-gray-600 mt-1 line-clamp-2">{{ $task->description }}</p>
                                <div class="flex justify-between items-center mt-3">
                                    <span class="text-sm text-green-600">
                                        Due: {{ $task->due_date->format('M d, Y') }}
                                    </span>
                                    <span class="px-3 py-1 text-xs rounded-full 
                                        {{ $task->status == 'completed' ? 'bg-green-100 text-green-800' : 
                                           ($task->status == 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal (hidden by default) -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Reject Leave Request</h3>
                <form id="rejectForm" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <label for="reason" class="block text-sm font-medium text-gray-700">Reason</label>
                        <textarea id="reason" name="reason" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></textarea>
                    </div>
                    <div class="flex justify-between mt-4">
                        <button type="button" onclick="closeRejectModal()" 
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Confirm Rejection
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRejectModal(requestId) {
            document.getElementById('rejectForm').action = `/leave/reject/${requestId}`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
@else
    <!-- LOGIN VIEW -->
    <div class="flex flex-col sm:flex-row h-screen">
        <!-- Left Half: Manager Photo -->
        <div class="w-full sm:w-1/2 bg-green-900 flex items-center justify-center p-8 fade-in">
            <img src="https://via.placeholder.com/500x500?text=Manager+Portal" alt="Manager Portal" class="rounded-lg hover-scale">
        </div>

        <!-- Right Half: Authentication Form -->
        <div class="w-full sm:w-1/2 bg-white flex items-center justify-center p-8 fade-in">
            <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
                <h2 class="text-3xl font-bold text-green-900 mb-6 text-center">Manager Login</h2>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('manager.login') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="matricul_manager" class="block text-gray-700">Matricule</label>
                        <input type="text" id="matricul_manager" name="matricul_manager" 
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" 
                               placeholder="Enter your matricule" required>
                    </div>
                    <div class="mb-6">
                        <label for="password" class="block text-gray-700">Password</label>
                        <input type="password" id="password" name="password" 
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" 
                               placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 hover-scale">
                        Login
                    </button>
                </form>
            </div>
        </div>
    </div>
@endisset
</body>
</html>