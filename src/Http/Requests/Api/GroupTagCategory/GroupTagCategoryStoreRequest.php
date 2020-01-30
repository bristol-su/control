<?php

namespace BristolSU\ControlDB\Http\Requests\Api\GroupTagCategory;

use Illuminate\Foundation\Http\FormRequest;

class GroupTagCategoryStoreRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'required|string|min:1|max:255',
            'description' => 'required|string|min:1|max:65335',
            'reference' => 'required|string',
        ];
    }

}
