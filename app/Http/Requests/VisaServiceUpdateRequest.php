<?php

namespace App\Http\Requests;

use App\Models\VisaService;
use Illuminate\Foundation\Http\FormRequest;

class VisaServiceUpdateRequest extends FormRequest
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
        $visaServiceId = VisaService::findOrFail(request('id'))->id;

        return [
            'name' => 'nullable | string',
            'passport' => "nullable | string | unique:visa_services,passport,$visaServiceId",
            'passport_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'service_type' => 'nullable | string',
            'visa_type' => 'nullable | string',
            'visa_entry_date' => 'nullable | date',
            'visa_expiry_date' => 'nullable | date',
            'appointment_date' => 'nullable | date',
            'new_visa_expired_date' => 'nullable | date',
            'status' => 'nullable | string',
        ];
    }
}
