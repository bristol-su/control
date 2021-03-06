<?php

namespace BristolSU\ControlDB\Http\Requests\Api\RoleTagCategory;

use Illuminate\Foundation\Http\FormRequest;

class RoleTagCategoryUpdateRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'nullable|string|min:1|max:255',
            'description' => 'nullable|string|min:1|max:65335',
            'reference' => 'nullable|string',
        ];
    }

}
