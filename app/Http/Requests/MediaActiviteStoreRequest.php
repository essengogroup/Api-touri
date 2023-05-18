<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediaActiviteStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'nullable|string|max:255',
            'is_main' => 'nullable|boolean',
        ];
    }
}
