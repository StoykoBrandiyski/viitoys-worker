@extends('layouts.app')

@section('content')
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="max-w-2xl mx-auto p-4">
        @csrf

        <div id="product-container" class="space-y-6">
            <div class="product-block bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden transition-all duration-300">
                <div class="bg-gray-50 px-4 py-2 border-b border-gray-200 flex justify-between items-center">
                    <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Продукт #1</span>
                </div>

                <div class="p-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Име на продукта</label>
                        <input type="text" name="products[0][name]" placeholder="Напр. Лего пожарна..."
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Снимки на продукта</label>
                        <input type="file" name="products[0][images][]" multiple onchange="previewImages(this, 0)" enctype="multipart/form-data"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">

                        <div id="preview-0" class="mt-3 grid grid-cols-4 gap-2"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 p-5 bg-slate-50 rounded-xl border border-gray-200 shadow-sm">
            <label for="processing_profile_id" class="block text-sm font-bold text-gray-700 mb-2">
                🤖 Избери профил за обработка (Размери & Воден знак)
            </label>
            <div class="relative">
                <select name="processing_profile_id" id="processing_profile_id" required
                        class="w-full px-4 py-3 bg-white rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition appearance-none cursor-pointer text-gray-800 font-medium">
                    <option value="" disabled selected>-- Моля, избери профил --</option>
                    @foreach($profiles as $profile)
                        <option value="{{ $profile->id }}" {{ old('processing_profile_id') == $profile->id ? 'selected' : '' }}>
                            {{ $profile->name }} ({{ $profile->width }}x{{ $profile->height }}px)
                        </option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                    </svg>
                </div>
            </div>
            @error('processing_profile_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-6 flex flex-col gap-4">
            <button type="button" id="add-more" class="w-full bg-white border-2 border-dashed border-gray-300 hover:border-blue-500 hover:text-blue-600 text-gray-500 font-bold py-4 rounded-xl transition-all flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Добави още един продукт
            </button>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-extrabold py-4 rounded-xl shadow-lg transform active:scale-95 transition-all text-lg uppercase tracking-wide">
                Качи и обработи всички
            </button>
        </div>
    </form>

    <script>
        let productIndex = 1;

        function previewImages(input, index) {
            const previewContainer = document.getElementById(`preview-${index}`);
            previewContainer.innerHTML = '';

            if (input.files) {
                Array.from(input.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imgWrapper = document.createElement('div');
                        imgWrapper.className = "relative h-20 w-full bg-gray-100 rounded-lg overflow-hidden border border-gray-200";
                        imgWrapper.innerHTML = `<img src="${e.target.result}" class="object-cover h-full w-full">`;
                        previewContainer.appendChild(imgWrapper);
                    }
                    reader.readAsDataURL(file);
                });
            }
        }

        document.getElementById('add-more').addEventListener('click', function() {
            const container = document.getElementById('product-container');
            const newIndex = productIndex;

            const html = `
        <div class="product-block bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden transition-all duration-300 mt-6">
            <div class="bg-gray-50 px-4 py-2 border-b border-gray-200 flex justify-between items-center">
                <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Продукт #${newIndex + 1}</span>
                <button type="button" onclick="this.closest('.product-block').remove()" class="text-red-400 hover:text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                </button>
            </div>
            <div class="p-4 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Име на продукта</label>
                    <input type="text" name="products[${newIndex}][name]" placeholder="Име..." class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Снимки на продукта</label>
                    <input type="file" name="products[${newIndex}][images][]" multiple onchange="previewImages(this, ${newIndex})"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-50 file:text-blue-700">
                    <div id="preview-${newIndex}" class="mt-3 grid grid-cols-4 gap-2"></div>
                </div>
            </div>
        </div>`;

            container.insertAdjacentHTML('beforeend', html);
            productIndex++;
        });
    </script>
@endsection
