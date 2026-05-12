@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row border border-gray-100">
        <!-- Image Branding -->
        <div class="md:w-1/2 bg-blue-700 relative hidden md:block">
            <img src="https://images.unsplash.com/photo-1497215728101-856f4ea42174?auto=format&fit=crop&q=80&w=1000"
                 alt="Office" class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-50">
            <div class="relative h-full flex flex-col justify-center px-12 text-white">
                <h1 class="text-4xl font-bold mb-4">Join Our Community</h1>
                <p class="text-lg text-blue-100">Set up your profile in seconds and start managing your users effectively.</p>
            </div>
        </div>

        <!-- Registration Form -->
        <div class="md:w-1/2 p-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Create Account</h2>

            <form action="{{ url('/users') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Full Name</label>
                    <input type="text" name="username" value="{{ old('username') }}" required
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Password</label>
                    <input type="password" name="password" required
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit"
                        class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition duration-200">
                    Register Now
                </button>
            </form>
        </div>
    </div>
@endsection
