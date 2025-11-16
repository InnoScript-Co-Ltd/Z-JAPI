<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployerStoreRequest extends FormRequest
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
            'full_name' => 'required | string',
            'national_card_number' => 'required | unique:employers,national_card_number',
            'household_photo' => 'nullable | image|mimes:jpeg,png,jpg,gif|max:5120',
            'national_card_photo' => 'nullable | image|mimes:jpeg,png,jpg,gif|max:5120',
            'employer_type' => 'required | string',
            'company_documents' => 'nullable | string',
        ];
    }
}
