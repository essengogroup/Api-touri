<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteRequest extends FormRequest
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
            "departement_id" => "nullable",
            "name" => "nullable|string|max:255",
            "description" => "nullable|string",
            "address" => "nullable|string",
            "is_date_required" => "nullable|boolean",
            "is_active" => "nullable|boolean",
            "price" => "nullable|alpha_num",
            "latitude" => "nullable",
            "longitude" => "nullable"
        ];
    }
}
