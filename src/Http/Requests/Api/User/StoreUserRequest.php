<?php

namespace BristolSU\ControlDB\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{

    public function rules()
    {
        return [
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email',
            'dob' => 'nullable|date_format:d-m-Y',
            'preferred_name' => 'nullable|string|max:255',
        ];
    }

}
