
<!-- Profile Name -->
<div>
    <label class="block text-sm font-bold text-slate-700 mb-2">Profile Name</label>
    <input type="text" name="name" value="{{ old('name', $profile->name) }}" required
           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition">
</div>

<!-- AI Engine -->
<div>
    <label class="block text-sm font-bold text-slate-700 mb-2">AI Engine</label>
    <select name="ai_engine_id" required
            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition">
        <option value="">Select an AI Engine</option>
        @foreach($aiEngines as $engine)
            <option value="{{ $engine->id }}" {{ old('ai_engine_id', $profile->engine_id ?? '') == $engine->id ? 'selected' : '' }}>
                {{ $engine->model_name }}
            </option>
        @endforeach
    </select>
</div>

<div class="grid grid-cols-2 gap-6">
    <!-- Width -->
    <div>
        <label class="block text-sm font-bold text-slate-700 mb-2">Width (px)</label>
        <input type="number" name="width" value="{{ old('width', $profile->width ?? 500) }}" required
               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition">
    </div>

    <!-- Height -->
    <div>
        <label class="block text-sm font-bold text-slate-700 mb-2">Height (px)</label>
        <input type="number" name="height" value="{{ old('height', $profile->height ?? 500) }}" required
               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition">
    </div>
</div>

<!-- Watermark Upload -->
<div class="p-4 border border-gray-200 rounded-xl bg-gray-50">
    <label class="block text-sm font-bold text-slate-700 mb-2">Watermark Image (Optional)</label>

    @if($profile->watermark_path)
        <div class="mb-3">
            <img src="{{ asset('storage/' . $profile->watermark_path) }}" alt="Current Watermark" class="h-16 rounded shadow-sm">
            <p class="text-xs text-gray-500 mt-1">Leave empty to keep current image.</p>
        </div>
    @endif

    <input type="file" name="watermark_file" accept="image/*"
           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
</div>

<!-- Image File Format -->
<div>
    <label class="block text-sm font-bold text-slate-700 mb-2">Output Image Format</label>
    <select name="image_file_format" required
            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition">
        <option value="png" {{ old('image_file_format', $profile->image_file_format ?? 'png') == 'png' ? 'selected' : '' }}>
            PNG - Best for transparency (Larger file)
        </option>
        <option value="jpg" {{ old('image_file_format', $profile->image_file_format ?? 'png') == 'jpg' ? 'selected' : '' }}>
            JPG - Smaller files, no transparency
        </option>
        <option value="webp" {{ old('image_file_format', $profile->image_file_format ?? 'png') == 'webp' ? 'selected' : '' }}>
            WebP - Modern format, smaller files
        </option>
        <option value="gif" {{ old('image_file_format', $profile->image_file_format ?? 'png') == 'gif' ? 'selected' : '' }}>
            GIF - For animations
        </option>
    </select>
</div>

<!-- Watermark Toggle -->
<div class="flex items-center p-4 bg-blue-50 rounded-xl border border-blue-100">
    <label class="relative inline-flex items-center cursor-pointer">
        <input type="checkbox" name="is_watermark_enabled" value="1" class="sr-only peer"
            {{ old('is_watermark_enabled', $profile->is_watermark_enabled) ? 'checked' : '' }}>
        <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
        <span class="ml-3 text-sm font-medium text-blue-900">Enable Watermark</span>
    </label>
</div>
