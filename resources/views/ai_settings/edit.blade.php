@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto">
        <!-- Update Form Section -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 mb-6">
            <!-- Header Section -->
            <div class="bg-slate-50 border-b border-gray-100 p-6 text-center">
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Редакция на AI конфигурация</h2>
                <p class="text-slate-500 mt-2">Актуализирайте вашия Gemini модел настройки</p>
            </div>

            <!-- Update Form -->
            <form id="updateForm" action="{{ route('ai-settings.update', $ai_setting->id) }}" method="POST" class="p-8 space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- API Key -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700 mb-2">🔑 Gemini API Key</label>
                        <input type="password" name="api_key"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all font-mono"
                               placeholder="AIza..." value="{{ old('api_key') }}">
                        <p class="mt-2 text-xs text-slate-400 italic">Оставете празно, ако не искате да промените ключа. Ключът се съхранява криптиран.</p>
                    </div>

                    <!-- System Prompt -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700 mb-2">🧠 System Prompt (Инструкции)</label>
                        <textarea name="system_prompt" rows="5"
                                  class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                                  placeholder="Ти си експерт по детски играчки...">{{ old('system_prompt', $ai_setting->system_prompt) }}</textarea>
                    </div>

                    <!-- Model Selection -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">🤖 Модел</label>
                        <select name="model_name"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:ring-2 focus:ring-blue-500 outline-none transition-all appearance-none cursor-pointer">
                            <option value="gemini-2.5-flash" {{ old('model_name', $ai_setting->model_name) === 'gemini-2.5-flash' ? 'selected' : '' }}>Gemini 2.5 Flash (Най-бърз)</option>
                            <option value="gemini-2.5-pro" {{ old('model_name', $ai_setting->model_name) === 'gemini-2.5-pro' ? 'selected' : '' }}>Gemini 2.5 Pro (Най-умен)</option>
                            <option value="gemini-2.0-flash" {{ old('model_name', $ai_setting->model_name) === 'gemini-2.0-flash' ? 'selected' : '' }}>Gemini 2.0 Flash (Бърз)</option>
                            <option value="gemini-1.5-flash" {{ old('model_name', $ai_setting->model_name) === 'gemini-1.5-flash' ? 'selected' : '' }}>Gemini 1.5 Flash (Стар - Бърз)</option>
                            <option value="gemini-1.5-pro" {{ old('model_name', $ai_setting->model_name) === 'gemini-1.5-pro' ? 'selected' : '' }}>Gemini 1.5 Pro (Стар - Умен)</option>
                        </select>
                    </div>

                    <!-- Timeout -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">⏱️ Timeout (сек)</label>
                        <input type="number" name="max_timeout"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition-all"
                               value="{{ old('max_timeout', $ai_setting->max_timeout) }}">
                    </div>

                    <!-- Active Toggle -->
                    <div class="md:col-span-2 flex items-center p-4 bg-blue-50 rounded-xl border border-blue-100">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $ai_setting->is_active) ? 'checked' : '' }} id="activeSwitch">
                            <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            <span class="ml-3 text-sm font-medium text-blue-900">Активирай този AI движок</span>
                        </label>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex gap-4">
                    <button type="submit" form="updateForm"
                            class="flex-1 py-4 px-6 bg-slate-900 hover:bg-black text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform active:scale-[0.98]">
                        Актуализирай настройките
                    </button>
                    <a href="{{ route('ai-settings.index') }}"
                       class="flex-1 py-4 px-6 bg-gray-200 hover:bg-gray-300 text-slate-800 font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform active:scale-[0.98] text-center">
                        Отмени
                    </a>
                </div>
            </form>
        </div>

        <!-- Delete Form Section -->
        @if($ai_setting)
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-red-200">
                <div class="bg-red-50 border-b border-red-200 p-6">
                    <h3 class="text-xl font-bold text-red-800">🗑️ Опасна зона</h3>
                    <p class="text-red-600 text-sm mt-1">Изтрийте този AI движок (това не може да се отмени)</p>
                </div>
                <div class="p-6">
                    <form id="deleteForm" action="{{ route('ai-settings.destroy', $ai_setting->id) }}" method="POST"
                          onsubmit="return confirm('Сигурни ли сте? Този AI движок ще бъде изтрит.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" form="deleteForm"
                                class="w-full py-3 px-6 bg-red-500 hover:bg-red-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform active:scale-[0.98]">
                            Изтрий този AI движок
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection
