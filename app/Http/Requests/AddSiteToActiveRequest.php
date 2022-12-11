<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddSiteToActiveRequest extends FormRequest
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
            'site_id' => 'required_if:activite_id,|exists:sites,id',
            'activite_id' => 'required_if:site_id,|exists:activites,id',
            'type' => 'nullable|in:obligatoire,optionnel',
            'price' => 'required_if:type,optionnel|numeric'
        ];
    }
}
