@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-slate-50 border-b border-gray-100 p-6">
            <h2 class="text-2xl font-bold text-slate-800">Create Profile</h2>
        </div>

        <form action="{{ route('processing-profiles.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            @include('processing-profiles._form_fields', ['profile' => new App\Models\ProcessingProfile()])

            <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition">
                Save Profile
            </button>
        </form>
    </div>
@endsection
