@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md p-8 border border-gray-200">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Edit User Profile</h2>
            <a href="{{ url('/dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700">← Back to Dashboard</a>
        </div>

        <form action="{{ url('/storeEditUser') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Full Name -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Email Address -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Email Address</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">New Password (Optional)</label>
                <input type="password" name="password" placeholder="Leave blank to keep current password"
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="Confirm new password"
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                @error('password_confirmation') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Actions -->
            <div class="pt-4 flex space-x-3">
                <button type="submit"
                        class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg shadow transition">
                    Update Profile
                </button>
                <a href="{{ route('products.index') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-3 rounded-lg text-center transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
