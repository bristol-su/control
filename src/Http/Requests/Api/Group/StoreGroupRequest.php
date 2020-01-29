<?php

namespace BristolSU\ControlDB\Http\Requests\Api\Group;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroupRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email'
        ];
    }

}
