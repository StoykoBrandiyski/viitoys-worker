@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <!-- Header Section -->
        <div class="bg-slate-50 border-b border-gray-100 p-6 text-center">
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">AI Конфигурация</h2>
            <p class="text-slate-500 mt-2">Настройте вашия Gemini модел за генериране на съдържание</p>
        </div>

        <form action="{{ route('ai-settings.store') }}" method="POST" class="p-8 space-y-6">
        @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- API Key -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">🔑 Gemini API Key</label>
                    <input type="password" name="api_key"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all font-mono"
                           placeholder="AIza..." required>
                    <p class="mt-2 text-xs text-slate-400 italic">Ключът се съхранява криптиран в нашата база данни.</p>
                </div>

                <!-- System Prompt -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">🧠 System Prompt (Инструкции)</label>
                    <textarea name="system_prompt" rows="5"
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                              required placeholder="Ти си експерт по детски играчки...">{{ old('system_prompt') }}</textarea>
                </div>

                <!-- Model Selection -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">🤖 Модел</label>
                    <select name="model_name"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:ring-2 focus:ring-blue-500 outline-none transition-all appearance-none cursor-pointer">
                        <option value="gemini-1.5-flash">Gemini 1.5 Flash (Бърз)</option>
                        <option value="gemini-1.5-pro">Gemini 1.5 Pro (Умен)</option>
                    </select>
                </div>

                <!-- Timeout -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">⏱️ Timeout (сек)</label>
                    <input type="number" name="max_timeout"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition-all"
                           value="30">
                </div>

                <!-- Default Toggle -->
                <div class="md:col-span-2 flex items-center p-4 bg-blue-50 rounded-xl border border-blue-100">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked id="activeSwitch">
                        <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-sm font-medium text-blue-900">Използвай този профил по подразбиране</span>
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full py-4 px-6 bg-slate-900 hover:bg-black text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform active:scale-[0.98]">
                Запази настройките
            </button>
        </form>
    </div>
@endsection
