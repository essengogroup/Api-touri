<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationSiteRequest extends FormRequest
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
            'site_id' => 'required|integer|exists:sites,id',
            'user_id' => 'required|integer|exists:users,id',
            'commentaire' => 'nullable|string',
            'nb_personnes' => 'required|integer',
//            'price' => 'nullable|numeric',
            'activites' => 'nullable|array',
            'activites.*' => 'nullable|integer|exists:activites,id'
        ];
    }
}
