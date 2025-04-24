<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Profile | {{ $manager->prenom }} {{ $manager->nom }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .profile-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        .profile-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .info-item {
            @apply py-2 border-b border-gray-100 last:border-0;
        }
        .action-card {
            @apply flex flex-col items-center justify-center p-4 rounded-lg transition-all hover:shadow-md;
        }
        .btn {
            @apply flex items-center gap-2 px-4 py-2 rounded-lg transition-colors;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-sm p-6 max-w-5xl mx-auto profile-card">
            <!-- Header with navigation -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-green-800">Manager Profile</h1>
                    <p class="text-gray-500 mt-1">Welcome back, {{ $manager->prenom }}</p>
                </div>
                
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('manager.dashboard') }}" 
                       class="btn bg-green-600 hover:bg-green-700 text-white">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                    <form action="{{ route('manager.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn bg-red-500 hover:bg-red-600 text-white">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </button>
                    </form>
                </div>

                
            </div>

            <!-- Profile sections -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Personal Information -->
                <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 lg:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-green-700">
                            <i class="fas fa-user-circle mr-2"></i>Personal Information
                        </h2>
                        <button class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-pencil-alt"></i> Edit
                        </button>
                    </div>
                    <div class="space-y-2">
                        <div class="info-item">
                            <span class="font-medium text-gray-600">Matricule:</span>
                            <span class="block text-gray-800">{{ $manager->matricul_manager }}</span>
                        </div>
                        <div class="info-item">
                            <span class="font-medium text-gray-600">Full Name:</span>
                            <span class="block text-gray-800">{{ $manager->prenom }} {{ $manager->nom }}</span>
                        </div>
                        <div class="info-item">
                            <span class="font-medium text-gray-600">Email:</span>
                            <span class="block text-gray-800">{{ $manager->email ?? 'Not provided' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="font-medium text-gray-600">Phone:</span>
                            <span class="block text-gray-800">{{ $manager->telephone ?? 'Not provided' }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Professional Information -->
                <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
                    <h2 class="text-xl font-semibold text-green-700 mb-4">
                        <i class="fas fa-briefcase mr-2"></i>Professional Details
                    </h2>
                    <div class="space-y-2">
                        <div class="info-item">
                            <span class="font-medium text-gray-600">Department:</span>
                            <span class="block text-gray-800">{{ $manager->apartment }}</span>
                        </div>
                        <div class="info-item">
                            <span class="font-medium text-gray-600">Position:</span>
                            <span class="block text-gray-800">Manager</span>
                        </div>
                        <div class="info-item">
                            <span class="font-medium text-gray-600">Hire Date:</span>
                            <span class="block text-gray-800">
                                {{ $manager->created_at ? $manager->created_at->format('M d, Y') : 'N/A' }}
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="font-medium text-gray-600">Employment Duration:</span>
                            <span class="block text-gray-800">
                                @if($manager->created_at)
                                    {{ $manager->created_at->diffForHumans() }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

         
    </div>
</body>
</html>