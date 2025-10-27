<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisaServiceStoreRequest extends FormRequest
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
            'passport' => 'required | string | unique:visa_services,passport',
            'passport_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'service_type' => 'required | string',
            'visa_type' => 'required | string',
            'visa_entry_date' => 'nullable | date',
            'visa_expiry_date' => 'nullable | date',
            'appointment_date' => 'nullable | date',
            'new_visa_expired_date' => 'nullable | date',
            'status' => 'required | string',
        ];
    }
}
