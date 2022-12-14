<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiteRequest extends FormRequest
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
            "departement_id" => "required",
            "name" => "required|string|max:255",
            "description" => "nullable|string",
            "price" => "required",
            "latitude" => "nullable",
            "longitude" => "nullable"
        ];
    }
}
