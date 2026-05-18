@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="bg-slate-50 border-b border-gray-100 p-6 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-slate-800">{{ $product->name }}</h2>
            <a href="{{ route('products.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Back</a>
        </div>

        <div class="p-8 space-y-8">
            <!-- Status and Metadata -->
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Status</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mt-2
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

                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Created</p>
                    <p class="text-lg font-semibold text-gray-800 mt-2">{{ $product->created_at->format('M d, Y') }}</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Processing Profile</p>
                    <p class="text-lg font-semibold text-gray-800 mt-2">
                        {{ $product->processProfile?->name ?? 'N/A' }}
                    </p>
                </div>
            </div>

            <!-- Description -->
            @if($product->description)
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-8 rounded-xl border border-blue-200 shadow-sm">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <h3 class="text-sm font-bold text-blue-900 uppercase tracking-wider">AI Generated Description</h3>
                    </div>
                    <div class="text-gray-800 leading-relaxed space-y-3 text-justify">
                        @php
                            $lines = explode("\n", $product->description);
                        @endphp
                        @foreach($lines as $line)
                            @if(trim($line) !== '')
                                <p>{{ trim($line) }}</p>
                            @else
                                <div class="h-2"></div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Product Images -->
            <!-- Product Images -->
            <div class="space-y-8">
                <h3 class="text-xl font-bold text-gray-800 border-b pb-3">
                    Product Media Gallery ({{ $product->images->count() }})
                </h3>

                @if($product->images->count() > 0)
                    <div class="space-y-6">
                        @foreach($product->images as $index => $image)
                            <div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-sm">
                                <div class="text-sm font-semibold text-gray-500 mb-3">
                                    Image #{{ $index + 1 }}
                                </div>

                                <!-- Side-by-Side Comparison Grid -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                                    <!-- 1. Original Image Column -->
                                    <div class="space-y-2">
                                        <div class="flex justify-between items-center">
                                            <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Original Copy</span>
                                            <span class="px-2 py-0.5 text-xs font-medium bg-gray-100 text-gray-600 rounded-md">Source</span>
                                        </div>
                                        <div class="relative overflow-hidden rounded-xl border border-gray-200 bg-gray-50 aspect-square">
                                            @if($image->original_path && Storage::disk('public')->exists($image->original_path))
                                                <img src="{{ Storage::disk('public')->url($image->original_path) }}" alt="Original Product Image"
                                                     class="w-full h-full object-cover hover:scale-102 transition duration-300">
                                            @else
                                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                                                    <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 002-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    <span class="text-xs">Original file missing</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- 2. Processed Image Column -->
                                    <div class="space-y-2">
                                        <div class="flex justify-between items-center">
                                            <span class="text-xs font-bold uppercase tracking-wider text-indigo-500">AI Background Removed</span>
                                            <span class="px-2 py-0.5 text-xs font-medium bg-indigo-50 text-indigo-600 rounded-md">Processed</span>
                                        </div>
                                        <div class="relative overflow-hidden rounded-xl border border-gray-200 bg-gray-100 aspect-square pattern-grid-fallback">
                                        @if($image->processed_path && Storage::disk('public')->exists($image->processed_path))
                                            <!-- Transparent background layout trick so you can see the background removal quality -->
                                                <div class="absolute inset-0 bg-[linear-gradient(45deg,#e5e7eb_25%,transparent_25%),linear-gradient(-45deg,#e5e7eb_25%,transparent_25%),linear-gradient(45deg,transparent_75%,#e5e7eb_75%),linear-gradient(-45deg,transparent_75%,#e5e7eb_75%)] bg-[size:16px_16px] bg-[position:0_0,0_8px,8px_-8px,-8px_0] opacity-30"></div>

                                                <img src="{{ Storage::disk('public')->url($image->processed_path) }}" alt="Processed Product Image"
                                                     class="relative w-full h-full object-cover hover:scale-102 transition duration-300 z-10">
                                            @else
                                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 bg-gray-50">
                                                    <svg class="w-8 h-8 mb-1 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                                    <span class="text-xs">Processing or pending...</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 bg-gray-50 rounded-2xl border border-gray-200">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <p class="text-gray-500 font-medium">No images uploaded yet</p>
                    </div>
                @endif
            </div>

            <!-- AI Response -->
            @if($product->ai_raw_response)
                <div class="bg-purple-50 p-6 rounded-xl border border-purple-200">
                    <h3 class="text-sm font-bold text-purple-900 uppercase tracking-wider mb-3">AI Response</h3>
                    <pre class="text-sm text-gray-800 overflow-auto bg-white p-3 rounded border border-purple-100">{{ json_encode($product->ai_raw_response, JSON_PRETTY_PRINT) }}</pre>
                </div>
            @endif

            <!-- Actions -->
            <div class="flex gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('products.edit', $product) }}"
                   class="flex-1 text-center bg-amber-600 hover:bg-amber-700 text-white px-4 py-3 rounded-xl font-medium transition">
                    Edit
                </a>
                <form action="{{ route('products.destroy', $product) }}" method="POST" class="flex-1"
                      onsubmit="return confirm('Are you sure you want to delete this product?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-xl font-medium transition">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
