<?php

namespace BristolSU\ControlDB\Http\Requests\Api\PositionTag;

use Illuminate\Foundation\Http\FormRequest;

class PositionTagStoreRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'required|string|min:1|max:255',
            'description' => 'required|string|min:1|max:65335',
            'reference' => 'required|string',
            "tag_category_id" => 'required|integer|exists:control_tag_categories,id'
        ];
    }

}
