<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel CRUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased">
<nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-40">
    <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-2 text-xl font-bold text-blue-600 hover:text-blue-700 transition">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                </svg>
                ViiToys
            </a>

            @auth
            <!-- Navigation Menu -->
            <div class="flex items-center space-x-8">
                <!-- Products -->
                <a href="{{ route('products.index') }}"
                   class="flex items-center gap-2 text-gray-700 hover:text-blue-600 font-medium transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Products
                </a>

                <!-- Processing Profiles -->
                <a href="{{ route('processing-profiles.index') }}"
                   class="flex items-center gap-2 text-gray-700 hover:text-blue-600 font-medium transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Profiles
                </a>

                <!-- Settings Dropdown -->
                <div class="relative group">
                    <button class="flex items-center gap-2 text-gray-700 hover:text-blue-600 font-medium transition group-hover:text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Settings
                        <svg class="w-4 h-4 transition group-hover:rotate-180" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <a href="{{ url('/ai-settings') }}"
                           class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition first:rounded-t-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12a9 9 0 11-18 0 9 9 0 0118 0m-9 5h.01M12 12h4.01"></path>
                            </svg>
                            AI Engines
                        </a>
                        <a href="{{ route('products.index') }}"
                           class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            User Profile
                        </a>
                        <a href="{{ url('/editUser') }}"
                           class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition last:rounded-b-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- User Menu -->
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                <form action="{{ url('/logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg font-medium transition">
                        Logout
                    </button>
                </form>
            </div>
            @else
            <!-- Guest Menu -->
            <div class="flex items-center space-x-4">
                <a href="{{ url('/login') }}" class="text-gray-600 hover:text-blue-600 font-medium transition">Login</a>
                <a href="{{ url('/register') }}" class="px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 rounded-lg font-medium transition">Register</a>
            </div>
            @endauth
        </div>
    </div>
</nav>

<main class="py-12">
    <div class="container mx-auto px-4">
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                <div class="flex">
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            There were {{ $errors->count() }} errors with your submission
                        </h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
            @if(session('success'))
                <div id="alert-success" class="fixed top-5 right-5 z-50 p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200 shadow-lg" role="alert">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 1 1 1.414 1.414Z"/></svg>
                        <span class="font-medium">Success!</span> {{ session('success') }}
                    </div>
                </div>

                <script>
                    // Auto-hide after 3 seconds
                    setTimeout(() => {
                        const alert = document.getElementById('alert-success');
                        if (alert) {
                            alert.style.transition = "opacity 0.5s ease";
                            alert.style.opacity = "0";
                            setTimeout(() => alert.remove(), 500);
                        }
                    }, 3000);
                </script>
            @endif
        @yield('content')
    </div>
</main>
</body>
</html>
