<?php

namespace BristolSU\ControlDB\Http\Requests\Api\Role;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{

    public function rules()
    {
        return [
            'position_id' => 'required|integer|exists:control_positions,id',
            'group_id' => 'required|integer|exists:control_groups,id',
            'email' => 'nullable|string|email',
            'position_name' => 'nullable|string|max:255',
        ];
    }

}
