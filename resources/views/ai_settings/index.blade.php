@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">🤖 AI Движоци</h2>
                <p class="text-slate-500 mt-2">Управлявайте вашите Gemini AI конфигурации</p>
            </div>
            <a href="{{ route('ai-settings.create') }}"
               class="px-6 py-3 bg-slate-900 hover:bg-black text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                + Добави нов AI движок
            </a>
        </div>

        @if($settings->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 p-12 text-center">
                <div class="text-6xl mb-4">🔌</div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Няма конфигурирани AI движоци</h3>
                <p class="text-slate-500 mb-6">Създайте вашата първа Gemini AI конфигурация</p>
                <a href="{{ route('ai-settings.create') }}"
                   class="inline-block px-6 py-3 bg-slate-900 hover:bg-black text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                    Създай AI движок
                </a>
            </div>
        @else
            <!-- AI Engines List -->
            <div class="space-y-4">
                @foreach($settings as $engine)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow">
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-xl font-bold text-slate-800">{{ $engine->model_name }}</h3>
                                        <div class="flex gap-2">
                                            @if($engine->is_active)
                                                <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full">✓ Активен</span>
                                            @else
                                                <span class="inline-block px-3 py-1 bg-gray-100 text-gray-800 text-xs font-bold rounded-full">Неактивен</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4 text-sm">
                                        <div>
                                            <span class="text-slate-500 font-semibold">Timeout</span>
                                            <p class="text-slate-800 font-bold">{{ $engine->max_timeout }}s</p>
                                        </div>
                                        <div>
                                            <span class="text-slate-500 font-semibold">API Key</span>
                                            <p class="text-slate-800 font-mono text-xs">{{ substr($engine->api_key ?? '', 0, 15) }}...</p>
                                        </div>
                                        <div>
                                            <span class="text-slate-500 font-semibold">System Prompt</span>
                                            <p class="text-slate-800 truncate">{{ \Illuminate\Support\Str::limit($engine->system_prompt, 40) }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex gap-2 ml-4">
                                    <a href="{{ route('ai-settings.edit', $engine->id) }}"
                                       class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-lg transition-all text-sm">
                                        ✏️ Редакция
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Add New Button -->
            <div class="mt-8 text-center">
                <a href="{{ route('ai-settings.create') }}"
                   class="inline-block px-8 py-3 bg-slate-900 hover:bg-black text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                    + Добави още един AI движок
                </a>
            </div>
        @endif
    </div>
@endsection
