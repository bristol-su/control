<?php

namespace BristolSU\ControlDB\Http\Requests\Api\Position;

use Illuminate\Foundation\Http\FormRequest;

class StorePositionRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'required|string|min:1|max:255',
            'description' => 'required|string|min:1|max:65335'
        ];
    }

}
