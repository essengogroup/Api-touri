<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HebergementStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'image_path' => 'required|image',
            'price' => 'required|numeric',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_available' => 'required|boolean',
        ];
    }
}
