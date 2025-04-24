<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom CSS for animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 1s ease-out;
        }

        .hover-scale {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Header Section -->
    <div class="flex justify-between items-center p-6 sm:p-8">
        <!-- Logo in Top-Left -->
        <div class="text-2xl sm:text-3xl font-bold text-blue-900 fade-in">
            <span>MyCompany</span>
        </div>

        <!-- Director and Supporter Buttons in Top-Right -->
        <div class="flex space-x-4 fade-in">
            <button class="px-6 py-2 bg-blue-900 text-white rounded-lg hover:bg-blue-700 hover-scale">
                Director
            </button>
            <button class="px-6 py-2 bg-blue-900 text-white rounded-lg hover:bg-blue-700 hover-scale">
                Supporter
            </button>
        </div>
    </div>

    <!-- Center Buttons (Employer & Manager) -->
    <div class="flex flex-col sm:flex-row items-center justify-center h-[calc(100vh-120px)] space-y-6 sm:space-y-0 sm:space-x-8 p-4 fade-in">
        <!-- Employer Button -->
        <a href="{{route('employer')}}" class="w-48 h-48 sm:w-64 sm:h-64 bg-blue-500 text-white text-2xl font-semibold rounded-lg hover:bg-blue-600 hover-scale flex items-center justify-center text-center">
            Employer
        </a>

        <!-- Manager Button -->
        <a href="{{ route('manager.login') }}" class="w-48 h-48 sm:w-64 sm:h-64 bg-green-500 text-white text-2xl font-semibold rounded-lg hover:bg-green-600 hover-scale flex items-center justify-center text-center">
    Manager
</a>

    </div>

</body>
</html>