@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-slate-50 border-b border-gray-100 p-6 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-slate-800">Edit Product</h2>
            <a href="{{ route('products.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Back</a>
        </div>

        <form action="{{ route('products.update', $product) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- Product Name -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Product Name</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                <textarea name="description" rows="4"
                          class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Processing Profile -->
            <div>
                <label for="processing_profile_id" class="block text-sm font-bold text-slate-700 mb-2">Processing Profile</label>
                <select name="processing_profile_id" id="processing_profile_id" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition">
                    <option value="">Select a profile</option>
                    @foreach($profiles as $profile)
                        <option value="{{ $profile->id }}" {{ old('processing_profile_id', $product->processing_profile_id) == $profile->id ? 'selected' : '' }}>
                            {{ $profile->name }} ({{ $profile->width }}x{{ $profile->height }}px)
                        </option>
                    @endforeach
                </select>
                @error('processing_profile_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status Display -->
            <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                <label class="block text-sm font-bold text-slate-700 mb-2">Status</label>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($product->status === 'processed')
                        bg-green-100 text-green-800 border border-green-200
                    @elseif($product->status === 'pending')
                        bg-amber-100 text-amber-800 border border-amber-200
                    @else
                        bg-red-100 text-red-800 border border-red-200
                    @endif
                ">
                    {{ ucfirst($product->status) }}
                </span>
            </div>

            <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition">
                Update Product
            </button>
        </form>
    </div>
@endsection
