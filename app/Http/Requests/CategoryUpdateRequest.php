<?php

namespace App\Http\Requests;

use App\Enums\GeneralStatusEnum;
use App\Helpers\Enum;
use App\Models\Categories;
use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
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
        $categoryId = Categories::findOrFail(request('id'))->id;
        $generalStatus = implode(',', (new Enum(GeneralStatusEnum::class))->values());

        return [
            'label' => "nullable | unique:categories,label,$categoryId",
            'description' => 'nullable | string',
            'status' => "nullable | string | in:$generalStatus",
        ];
    }
}
