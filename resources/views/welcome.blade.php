@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-2xl p-8 shadow-lg">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-4xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h1>
                <p class="text-blue-100">Here's what's happening with your products today</p>
            </div>
            <div class="text-6xl opacity-20">📦</div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Total Products -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Products</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ Auth::user()->products()->count() ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-xl">📦</div>
            </div>
        </div>

        <!-- Processing Profiles -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Profiles</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ Auth::user()->processingProfiles()->count() ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-xl">⚙️</div>
            </div>
        </div>

        <!-- Processed -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Processed</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ Auth::user()->products()->where('status', 'processed')->count() ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-xl">✅</div>
            </div>
        </div>

        <!-- Pending -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Processing</p>
                    <p class="text-3xl font-bold text-amber-600 mt-2">{{ Auth::user()->products()->whereIn('status', ['pending', 'processing'])->count() ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center text-xl">⏳</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('products.create') }}"
               class="flex items-center gap-4 p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl hover:shadow-md transition border border-blue-200">
                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center text-white text-xl">➕</div>
                <div>
                    <p class="font-semibold text-gray-900">Upload Products</p>
                    <p class="text-sm text-gray-600">Add new products for processing</p>
                </div>
            </a>

            <a href="{{ route('processing-profiles.index') }}"
               class="flex items-center gap-4 p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-xl hover:shadow-md transition border border-green-200">
                <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center text-white text-xl">⚙️</div>
                <div>
                    <p class="font-semibold text-gray-900">Manage Profiles</p>
                    <p class="text-sm text-gray-600">Create or edit processing profiles</p>
                </div>
            </a>

            <a href="{{ url('/ai-settings') }}"
               class="flex items-center gap-4 p-4 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl hover:shadow-md transition border border-purple-200">
                <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center text-white text-xl">🤖</div>
                <div>
                    <p class="font-semibold text-gray-900">AI Settings</p>
                    <p class="text-sm text-gray-600">Configure Gemini API</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Products -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Recent Products</h2>
                <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">View all →</a>
            </div>
        </div>

        @php
            $recentProducts = Auth::user()->products()->latest()->limit(5)->get();
        @endphp

        @if($recentProducts->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Product Name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Profile</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Created</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recentProducts as $product)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-900">{{ $product->name }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    @if($product->status === 'processed')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                            Processed
                                        </span>
                                    @elseif($product->status === 'processing' || $product->status === 'pending')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                            <svg class="w-3 h-3 mr-1 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                            {{ ucfirst($product->status) }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            Failed
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-600">{{ $product->processProfile?->name ?? 'N/A' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-600">{{ $product->created_at->format('M d, Y') }}</p>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('products.show', $product) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">View →</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center">
                <div class="inline-block p-4 bg-gray-100 rounded-full mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Products Yet</h3>
                <p class="text-gray-600 mb-4">Start by uploading your first product</p>
                <a href="{{ route('products.create') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition">
                    Upload Products
                </a>
            </div>
        @endif
    </div>

    <!-- Features Section -->
    <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-xl shadow-sm border border-indigo-200 p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">How ViiToys Works</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-600 text-white font-bold text-lg">1</div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Upload Products</h3>
                    <p class="text-gray-600 mt-2">Upload product images and set up processing profiles with your preferred dimensions and watermark.</p>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-600 text-white font-bold text-lg">2</div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Automatic Processing</h3>
                    <p class="text-gray-600 mt-2">Images are processed automatically with background removal, resizing, and watermarking every 10 minutes.</p>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-600 text-white font-bold text-lg">3</div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">AI Descriptions</h3>
                    <p class="text-gray-600 mt-2">Gemini AI automatically generates detailed product descriptions based on the processed images.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
