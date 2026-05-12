<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel CRUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased">
<nav class="bg-white border-b border-gray-200 p-4 shadow-sm">
    <div class="container mx-auto flex justify-between items-center">
        <a href="{{ url('/dashboard') }}" class="text-xl font-bold text-blue-600">UserAdmin</a>
        <div class="flex items-center space-x-6">
            @auth
                <span class="text-gray-700 font-medium">Welcome, {{ auth()->user()->name }}</span>
                <form action="{{ url('/logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-semibold">Logout</button>
                </form>
            @else
                <a href="{{ url('/login') }}" class="text-gray-600 hover:text-blue-600">Login</a>
                <a href="{{ url('/register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Register</a>
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
