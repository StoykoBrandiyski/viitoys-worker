@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Processing Profiles</h2>
            <a href="{{ route('processing-profiles.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition">
                + Create New Profile
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 text-green-700 border-l-4 border-green-500 rounded-r-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider">
                    <th class="p-4 rounded-tl-lg">Name</th>
                    <th class="p-4">Dimensions</th>
                    <th class="p-4">Watermark</th>
                    <th class="p-4 rounded-tr-lg">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @forelse($profiles as $profile)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 font-medium text-gray-800">{{ $profile->name }}</td>
                        <td class="p-4 text-gray-600">{{ $profile->width }} x {{ $profile->height }} px</td>
                        <td class="p-4">
                            @if($profile->is_watermark_enabled)
                                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full font-semibold">Enabled</span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-500 text-xs rounded-full font-semibold">Disabled</span>
                            @endif
                        </td>
                        <td class="p-4 flex space-x-3">
                            <a href="{{ route('processing-profiles.edit', $profile) }}" class="text-blue-500 hover:text-blue-700 font-medium">Edit</a>
                            <form action="{{ route('processing-profiles.destroy', $profile) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-gray-500">No profiles found. Create one to get started.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $profiles->links() }}
        </div>
    </div>
@endsection
