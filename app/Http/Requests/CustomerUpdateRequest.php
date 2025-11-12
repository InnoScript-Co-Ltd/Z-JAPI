<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
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
        $customerId = Customer::findOrFail(request('id'))->id;

        return [
            'name' => 'nullable | string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'nrc' => "nullable | string | unique:customers,nrc,$customerId",
            'nrc_front' => 'nullable |image|mimes:jpeg,png,jpg,gif|max:5120',
            'nrc_back' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'passport' => "nullable | string | unique:customers,passport,$customerId",
            'passport_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'dob' => 'nullable | date',
            'phone' => "nullable | string | unique:customers,phone,$customerId",
            'email' => "nullable | unique:customers,email,$customerId",
            'contact_by' => 'nullable | string',
            'social_app' => 'nullable | string',
            'social_link_qrcode' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'household_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'remark' => 'nullable | string',
            'status' => 'nullable | string',
        ];
    }
}
