<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveProcessingProfileRequest extends FormRequest {
    public function authorize(): bool {
        return true; // Authentication is handled by middleware
    }

    public function rules(): array {
        return [
            'name' => 'required|string|max:255',
            'width' => 'required|integer|min:10|max:5000',
            'height' => 'required|integer|min:10|max:5000',
            'watermark_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_watermark_enabled' => 'nullable|boolean',
        ];
    }
}
