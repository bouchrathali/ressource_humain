<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
            <!-- Navigation -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-blue-900">My Profile</h1>
                <div class="flex space-x-4">
                    <a href="{{ route('employer.dashboard') }}" 
                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                        Back to Dashboard
                    </a>
                    <a href="{{ route('employer.logout') }}" 
                       class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                        Logout
                    </a>
                </div>
            </div>

            <!-- Profile Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold mb-4 text-blue-800 border-b pb-2">Personal Information</h2>
                    <div class="space-y-3">
                        <p><span class="font-medium">Matricule:</span> {{ $employer->matricul_employer }}</p>
                        <p><span class="font-medium">Name:</span> {{ $employer->prenom }} {{ $employer->nom }}</p>
                        <p><span class="font-medium">Email:</span> {{ $employer->email }}</p>
                        <p><span class="font-medium">Phone:</span> {{ $employer->telephone }}</p>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold mb-4 text-blue-800 border-b pb-2">Professional Information</h2>
                    <div class="space-y-3">
                        <p><span class="font-medium">Role:</span> {{ $employer->role }}</p>
                        <p><span class="font-medium">Position:</span> {{ $employer->post }}</p>
                        <p><span class="font-medium">Department:</span> {{ $employer->apartment }}</p>
                        <p><span class="font-medium">Hire Date:</span> {{ $employer->date_embauche }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>