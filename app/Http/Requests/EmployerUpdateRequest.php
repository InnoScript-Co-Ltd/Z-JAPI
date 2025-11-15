<?php

namespace App\Http\Requests;

use App\Models\Employer;
use Illuminate\Foundation\Http\FormRequest;

class EmployerUpdateRequest extends FormRequest
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
        $employerId = Employer::findOrFail(request('id'))->id;

        return [
            'full_name' => 'nullable | string',
            'national_card_number' => "nullable | unique:employers,national_card_number,$employerId",
            'household_photo' => 'nullable | image|mimes:jpeg,png,jpg,gif|max:5120',
            'national_card_photo' => 'nullable | image|mimes:jpeg,png,jpg,gif|max:5120',
            'employer_type' => 'nullable | string',
            'company_documents' => 'nullable | array',
            'company_documents.*' => 'file|mimes:jpeg,png,jpg,gif,pdf,doc,docx,xls,xlsx|max:5120',
            'update_documents' => 'nullable | string',
        ];
    }
}
