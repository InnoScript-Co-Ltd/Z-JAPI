<?php

namespace App\Http\Requests;

use App\Enums\GeneralStatusEnum;
use App\Models\Categories;
use Illuminate\Foundation\Http\FormRequest;

class CategoryServiceStoreRequest extends FormRequest
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
        $categories = Categories::where(['status' => GeneralStatusEnum::ACTIVE->value])->pluck('id')->toArray();
        $categoriesId = implode(',', $categories);

        return [
            'category_id' => "required | in:$categoriesId",
            'name' => 'required | unique:category_services,name',
            'fees' => 'required | numeric',
            'description' => 'nullable | string',
        ];
    }
}
