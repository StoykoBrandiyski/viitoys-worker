<?php

namespace App\Http\Controllers;

use App\Models\ProcessingProfile;
use App\Http\Requests\SaveProcessingProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProcessingProfileController extends Controller {

    public function index() {
        // Only fetch profiles belonging to the logged-in user
        $profiles = ProcessingProfile::where('user_id', Auth::id())->paginate(10);
        return view('processing-profiles.index', compact('profiles'));
    }

    public function create() {
        $aiEngines = Auth::user()->aiSettings;
        return view('processing-profiles.form', compact('aiEngines'));
    }

    public function store(SaveProcessingProfileRequest $request) {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['is_watermark_enabled'] = $request->has('is_watermark_enabled');

        if ($request->hasFile('watermark_file')) {
            $data['watermark_path'] = $request->file('watermark_file')->store('watermarks', 'public');
        }

        ProcessingProfile::create($data);

        return redirect()->route('processing-profiles.index')
            ->with('success', 'Profile created successfully.');
    }

    public function edit(ProcessingProfile $processingProfile) {
        // Security check: ensure user owns this profile
        if ($processingProfile->user_id !== Auth::id()) abort(403);

        $aiEngines = Auth::user()->aiSettings;
        return view('processing-profiles.edit', compact('processingProfile', 'aiEngines'));
    }

    public function update(SaveProcessingProfileRequest $request, ProcessingProfile $processingProfile) {
        if ($processingProfile->user_id !== Auth::id()) abort(403);

        $data = $request->validated();
        $data['is_watermark_enabled'] = $request->has('is_watermark_enabled');

        if ($request->hasFile('watermark_file')) {
            // Delete old watermark if exists
            if ($processingProfile->watermark_path) {
                Storage::disk('public')->delete($processingProfile->watermark_path);
            }
            $data['watermark_path'] = $request->file('watermark_file')->store('watermarks', 'public');
        }

        $processingProfile->update($data);

        return redirect()->route('processing-profiles.index')
            ->with('success', 'Profile updated successfully.');
    }

    public function destroy(ProcessingProfile $processingProfile) {
        if ($processingProfile->user_id !== Auth::id()) abort(403);

        if ($processingProfile->watermark_path) {
            Storage::disk('public')->delete($processingProfile->watermark_path);
        }

        $processingProfile->delete();

        return redirect()->route('processing-profiles.index')
            ->with('success', 'Profile deleted successfully.');
    }
}
