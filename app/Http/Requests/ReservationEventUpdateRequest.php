<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationEventUpdateRequest extends FormRequest
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
            'user_id' => 'nullable|integer',
            'event_id' => 'nullable|integer',
            'nb_persons' => 'nullable|integer',
            'status' => 'nullable|string|in:pending,accepted,refused,canceled,paid',
            'commentaire' => 'nullable|string',
            'price' => 'nullable|numeric',
        ];
    }
}
