<?php

namespace BristolSU\ControlDB\Http\Requests\Api\UserTag;

use Illuminate\Foundation\Http\FormRequest;

class UserTagUpdateRequest extends FormRequest
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
