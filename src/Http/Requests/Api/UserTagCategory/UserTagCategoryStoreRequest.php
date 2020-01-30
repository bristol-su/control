<?php

namespace BristolSU\ControlDB\Http\Requests\Api\UserTagCategory;

use Illuminate\Foundation\Http\FormRequest;

class UserTagCategoryStoreRequest extends FormRequest
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
