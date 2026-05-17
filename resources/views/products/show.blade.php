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
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4">Product Images ({{ $product->images->count() }})</h3>
                @if($product->images->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($product->images as $image)
                            <div class="relative group overflow-hidden rounded-xl border border-gray-200 bg-gray-50 aspect-square">
                                @if(Storage::disk('public')->exists($image->original_path))
                                    <img src="{{ asset('storage/' . $image->original_path) }}" alt="Product Image"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                        <span class="text-gray-400 text-sm">Image not found</span>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition duration-300"></div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 bg-gray-50 rounded-xl border border-gray-200">
                        <p class="text-gray-500">No images uploaded yet</p>
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
