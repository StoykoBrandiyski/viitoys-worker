<?php

namespace App\Http\Controllers;

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
        $settings = auth()->user()->aiSettings; // Връща настройките само на текущия потребител
        return view('ai_settings.index', compact('settings'));
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

        if (isset($data['api_key'])) {
            $data['auth_token'] = base64_encode($data['api_key']);
        }

        auth()->user()->aiSettings()->create($data + ['is_active' => $request->has('is_active')]);

        return redirect('/')->with('success', 'Настройката е запазена.');
    }
}
