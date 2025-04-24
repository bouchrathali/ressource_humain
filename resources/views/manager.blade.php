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
                    <h1 class="text-2xl font-bold text-gray-800">Welcome, {{ $manager->prenom}} {{ $manager->nom }}</h1>
                    <p class="text-gray-600">Department: {{ $manager->department }}</p>
                    <p class="text-gray-600"></p>
                </div>
            </div>
            
         <!-- Add this after the Team Overview section -->
<div class="mt-8 pt-6 border-t border-gray-200">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-green-700">
            <i class="fas fa-calendar-alt mr-2"></i>Upcoming Leave Requests
        </h2>
        <a href="{{ route('manager.leave.approvals') }}" class="text-blue-500 hover:text-blue-700 text-sm">
            View All <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
    
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Leave Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
    @forelse($pendingLeaves as $leave)
    <tr>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                    {{ strtoupper(substr($leave->employee->prenom, 0, 1)) }}{{ strtoupper(substr($leave->employee->nom, 0, 1)) }}
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">{{ $leave->employee->prenom }} {{ $leave->employee->nom }}</div>
                    <div class="text-sm text-gray-500">{{ $leave->employee->position }}</div>
                </div>
            </div>
        </td>
        <!-- Rest of your table row -->
    </tr>
    @empty
    <tr>
        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
            No pending leave requests
        </td>
    </tr>
    @endforelse
</tbody>
            </table>
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

        function calculateHoursWorked(checkIn, checkOut) {
            const start = new Date('1970-01-01T' + checkIn + 'Z');
            const end = new Date('1970-01-01T' + checkOut + 'Z');
            const diff = (end - start) / 1000 / 60 / 60;
            return Math.round(diff * 100) / 100 + ' hours';
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