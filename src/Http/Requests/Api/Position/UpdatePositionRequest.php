<?php

namespace BristolSU\ControlDB\Http\Requests\Api\Position;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePositionRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'nullable|string|min:1|max:255',
            'description' => 'nullable|string|min:1|max:65335'
        ];
    }

}
