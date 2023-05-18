<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventTouriUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'name' => 'nullable|string',
            'description' => 'nullable|string|max:200',
            'image_path' => 'nullable|string',
            'date_event' => 'nullable|date',
            'place' => 'nullable|integer',
            'price' => 'nullable|numeric',
            'status' => 'nullable|string|in:active,inactive',
        ];
    }
}
