@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">My Products</h2>
                <p class="text-sm text-gray-500 mt-1">Manage your generated product descriptions and their statuses.</p>
            </div>
            <a href="{{ route('products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium transition shadow-sm">
                + New Product
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg text-sm font-medium">
                {{ session('success') }}
            </div>
    @endif

    <!-- Data Table -->
        <div class="overflow-hidden border border-gray-200 rounded-xl">
            <table class="w-full text-left border-collapse">
                <thead>
                <tr class="bg-slate-50 text-slate-600 text-sm uppercase tracking-wider border-b border-gray-200">
                    <th class="p-4 font-semibold">ID</th>
                    <th class="p-4 font-semibold">Product Name</th>
                    <th class="p-4 font-semibold hidden md:table-cell">Description Extract</th>
                    <th class="p-4 font-semibold">Status</th>
                    <th class="p-4 font-semibold text-right">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($products as $product)
                    <tr class="hover:bg-slate-50 transition duration-150 ease-in-out">
                        <td class="p-4 text-slate-500 text-sm">
                            #{{ $product->id }}
                        </td>

                        <td class="p-4">
                        <span class="font-medium text-slate-800">
                            {{ $product->name ?? 'Untitled Product' }}
                        </span>
                        </td>

                        <td class="p-4 text-slate-500 text-sm hidden md:table-cell max-w-xs truncate">
                            {{ $product->description ? Str::limit($product->description, 50) : 'No description generated yet.' }}
                        </td>

                        <td class="p-4">
                            @if($product->status === 'processed')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                Processed
                            </span>
                            @elseif($product->status === 'pending')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                <svg class="w-3 h-3 mr-1 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                Pending
                            </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                Failed
                            </span>
                            @endif
                        </td>

                        <td class="p-4 text-right text-sm font-medium flex justify-end space-x-3">
                            <a href="{{ route('products.show', $product) }}" class="text-slate-500 hover:text-blue-600 transition">View</a>
                            <a href="{{ route('products.edit', $product) }}" class="text-slate-500 hover:text-amber-600 transition">Edit</a>

                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this product permanently?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-500 hover:text-red-600 transition">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                <h3 class="text-lg font-medium text-gray-900">No products found</h3>
                                <p class="text-gray-500 mt-1">You haven't generated any products yet.</p>
                                <a href="{{ route('products.create') }}" class="mt-4 text-blue-600 hover:text-blue-800 font-medium">+ Create your first product</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
@endsection
