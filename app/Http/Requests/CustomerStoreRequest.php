<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
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
            'name' => 'required | string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nrc' => 'nullable | string | unique:customers,nrc',
            'nrc_front' => 'nullable |image|mimes:jpeg,png,jpg,gif|max:2048',
            'nrc_back' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'passport' => 'nullable | string | unique:customers,passport',
            'passport_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'dob' => 'nullable | date',
            'phone' => 'nullable | string | unique:customers,phone',
            'email' => 'nullable | unique:customers,email',
            'contact_by' => 'nullable | string',
            'social_app' => 'nullable | string',
            'social_link_qrcode' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remark' => 'nullable | string',
            'status' => 'nullable | string',
            'year_of_insurance' => 'nullable | string',
            'fees' => 'nullable | numeric',
            'deposit_amount' => 'nullable | numeric',
            'balance' => 'nullable | numeric',
            'pink_card' => 'nullable | string',
            'employer' => 'nullable | string',
            'employer_type' => 'nullable | string',
            'employer_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'employer_household_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'employer_company_data' => 'nullable | string',
        ];
    }
}
