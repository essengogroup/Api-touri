<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransportStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() :bool
    {
        return true;
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
            'is_available' => 'required|boolean',
            'price' => 'required|numeric',
            'image_path' => 'required|image',
        ];
    }
}
