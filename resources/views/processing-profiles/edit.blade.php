@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-slate-50 border-b border-gray-100 p-6 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-slate-800">Edit Profile</h2>
            <a href="{{ route('processing-profiles.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Back</a>
        </div>

        <form action="{{ route('processing-profiles.update', $processingProfile) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf @method('PUT')
            @include('processing-profiles._form_fields', ['profile' => $processingProfile])

            <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition">
                Update Profile
            </button>
        </form>
    </div>
@endsection
