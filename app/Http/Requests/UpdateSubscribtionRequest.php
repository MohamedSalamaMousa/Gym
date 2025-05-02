<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubscribtionRequest extends FormRequest
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

            'member_id' => 'required|exists:members,id',
            'service_id' => 'required|exists:services,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'is_individual' => 'nullable|boolean',
            'captain_id' => 'nullable|exists:captains,id',
            'remaining_invitions' => 'nullable|integer|min:0',
            'captain_id' => 'required_if:is_individual,1|nullable|exists:captains,id',
            'captain_percentage' => 'required_if:is_individual,1|nullable|numeric|min:0|max:100',



        ];
    }
}
