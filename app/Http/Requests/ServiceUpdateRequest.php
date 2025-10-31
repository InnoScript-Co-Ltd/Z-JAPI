<?php

namespace App\Http\Requests;

use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;

class ServiceUpdateRequest extends FormRequest
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
        $serviceId = Service::findOrFail(request('id'))->id;

        return [
            'service_type' => "nullable | unique:services,service_type,$serviceId",
            'fees' => 'nullable | numeric',
            'description' => 'nullable | string',
        ];
    }
}
