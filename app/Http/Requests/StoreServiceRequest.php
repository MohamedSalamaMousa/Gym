<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'session_count' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'num_invitions' => 'required|integer|min:0', // New field for number of invitations
            'freeze_days' => 'required|integer|min:0',
        ];
    }
}
