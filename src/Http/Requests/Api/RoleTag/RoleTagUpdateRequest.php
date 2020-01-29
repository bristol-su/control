<?php

namespace BristolSU\ControlDB\Http\Requests\Api\RoleTag;

use Illuminate\Foundation\Http\FormRequest;

class RoleTagUpdateRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'nullable|string|min:1|max:255',
            'description' => 'nullable|string|min:1|max:65335',
            'reference' => 'nullable|string',
            "tag_category_id" => 'nullable|integer|exists:control_tag_categories,id'
        ];
    }

}
