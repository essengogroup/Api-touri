<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationEventStoreRequest extends FormRequest
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
            'user_id' => 'required|integer',
            'event_id' => 'required|integer',
            'nb_persons' => 'required|integer',
            'status' => 'required|string|in:pending,accepted,refused,canceled,paid',
            'commentaire' => 'nullable|string',
            'price' => 'required|numeric',
        ];
    }
}
