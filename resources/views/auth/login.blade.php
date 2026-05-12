@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden p-8 border border-gray-100">
        <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-8">Sign In</h2>

        <form action="{{ url('/users/authenticate') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="mt-1 block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Password</label>
                <input type="password" name="password" required
                       class="mt-1 block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>

            <button type="submit"
                    class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-md transition-all transform hover:-translate-y-0.5">
                Login
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-500">
            New here? <a href="{{ url('/register') }}" class="text-blue-600 font-semibold hover:underline">Create an account</a>
        </p>
    </div>
@endsection
