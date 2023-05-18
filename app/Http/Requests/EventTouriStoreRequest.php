<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventTouriStoreRequest extends FormRequest
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
            'name' => 'required|string',
            'description' => 'required|string|max:200',
            'image_path' => 'required|file|mimes:jpg,jpeg,png',
            'date_event' => 'required|date',
            'place' => 'nullable|integer',
            'price' => 'required|numeric',
            'status' => 'nullable|string|in:active,inactive',
        ];
    }
}
