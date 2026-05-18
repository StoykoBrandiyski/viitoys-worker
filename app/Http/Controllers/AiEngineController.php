<?php

namespace App\Http\Controllers;

use App\Models\AiEngine;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class AiEngineController extends Controller
{
    /**
     * @return View|Factory
     */
    public function index(): View|Factory
    {
        $settings = auth()->user()->aiSettings;
        return view('ai_settings.index', compact('settings'));
    }

    /**
     * Show the create form for a new AI Engine
     */
    public function create(): View|Factory
    {
        return view('ai_settings.create');
    }

    /**
     * @param Request $request
     * @return Redirector|RedirectResponse
     */
    public function store(Request $request): Redirector|RedirectResponse
    {
        $data = $request->validate([
            'api_key' => 'required|string',
            'system_prompt' => 'required|string',
            'model_name' => 'required|string',
            'max_timeout' => 'required|integer|min:1',
        ]);

        auth()->user()->aiSettings()->create($data + ['is_active' => $request->has('is_active')]);

        return redirect('/')->with('success', 'AI движокът е запазен успешно.');
    }

    /**
     * Show the edit form for an AI Engine
     */
    public function edit(AiEngine $ai_setting): View|Factory
    {
        // Ensure the engine belongs to the current user
        if ($ai_setting->user_id && $ai_setting->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // If no user_id is set, assign it to the current user
        if (!$ai_setting->user_id) {
            $ai_setting->update(['user_id' => auth()->id()]);
        }

        return view('ai_settings.edit', compact('ai_setting'));
    }

    /**
     * Update an AI Engine
     */
    public function update(Request $request, AiEngine $ai_setting): Redirector|RedirectResponse
    {
        // Ensure the engine belongs to the current user
        if ($ai_setting->user_id && $ai_setting->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // If no user_id is set, assign it to the current user
        if (!$ai_setting->user_id) {
            $ai_setting->update(['user_id' => auth()->id()]);
        }

        $data = $request->validate([
            'api_key' => 'nullable|string',
            'system_prompt' => 'required|string',
            'model_name' => 'required|string',
            'max_timeout' => 'required|integer|min:1',
        ]);

        // Only update api_key if provided
        if (empty($data['api_key'])) {
            unset($data['api_key']);
        }

        // Handle is_active checkbox
        $data['is_active'] = $request->has('is_active');

        $ai_setting->update($data);

        return redirect('/')->with('success', 'AI движокът е актуализиран успешно.');
    }

    /**
     * Delete an AI Engine
     */
    public function destroy(AiEngine $ai_setting): Redirector|RedirectResponse
    {
        // Ensure the engine belongs to the current user
        if ($ai_setting->user_id && $ai_setting->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $ai_setting->delete();

        return redirect('/')->with('success', 'AI движокът е изтрит успешно.');
    }
}
