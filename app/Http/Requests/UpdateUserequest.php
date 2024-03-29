<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserequest extends FormRequest
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
            'full_name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|unique:users,email',
            'phone' => 'nullable',
            'address' => 'nullable|string',
            'profile_picture' => 'nullable',
            'password' => 'nullable|string|max:255|min:8'
        ];
    }
}
