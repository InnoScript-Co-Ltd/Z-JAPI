<?php

namespace App\Http\Requests;

use App\Models\Categories;
use App\Models\CategoryService;
use App\Models\Customer;
use App\Models\Employer;
use Illuminate\Foundation\Http\FormRequest;

class OnboardingServiceStoreRequest extends FormRequest
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
        $customerIds = implode(',', Customer::pluck('id')->toArray());
        $categoryIds = implode(',', Categories::pluck('id')->toArray());
        $serviceIds = implode(',', CategoryService::pluck('id')->toArray());
        $employerIds = implode(',', Employer::pluck('id')->toArray());

        return [
            'customer_id' => "required | in:$customerIds",
            'category_id' => "required | in:$categoryIds",
            'category_service_id' => "required | in:$serviceIds",
            'employer_id' => "required | in:$employerIds",
            'customer_name' => 'required | string',
            'category' => 'required | string',
            'service' => 'required | string',
            'fees' => 'required | numeric',
            'deposit' => 'required | numeric',
            'balance' => 'required | numeric',
            'employer_type' => 'required | string',
            'employer_name' => 'required | string',
            'remark' => 'nullable | string',
            'status' => 'required | string',
        ];
    }
}
