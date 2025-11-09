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
            'nrc' => 'nullable | string | unique:customers,nrc',
            'passport' => 'nullable | string | unique:customers,passport',
            'dob' => 'nullable | date',
            'phone' => 'nullable | string | unique:customers,phone',
            'email' => 'nullable | unique:customers,email',
            'contact_by' => 'nullable | string',
            'social_app' => 'nullable | string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'nrc_front' => 'nullable |image|mimes:jpeg,png,jpg,gif|max:5120',
            'nrc_back' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'passport_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'household_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'social_link_qrcode' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'remark' => 'nullable | string',
            'status' => 'nullable | string',
        ];
    }
}
