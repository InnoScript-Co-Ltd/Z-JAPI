<?php

namespace App\Http\Requests;

use App\Enums\GeneralStatusEnum;
use App\Helpers\Enum;
use App\Models\Categories;
use App\Models\CategoryService;
use Illuminate\Foundation\Http\FormRequest;

class CategoryServiceUpdateRequest extends FormRequest
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
        $categoryServiceId = CategoryService::findOrFail(request('id'))->id;
        $categories = Categories::where(['status' => GeneralStatusEnum::ACTIVE->value])->pluck('id')->toArray();
        $categoriesId = implode(',', $categories);
        $generalStatus = implode(',', (new Enum(GeneralStatusEnum::class))->values());

        return [
            'category_id' => "nullable | in:$categoriesId",
            'name' => "nullable | unique:category_services,name,$categoryServiceId",
            'fees' => 'nullable | numeric',
            'description' => 'nullable | string',
            'status' => "nullable | string | in:$generalStatus",
        ];
    }
}
