<?php


namespace BristolSU\ControlDB\Repositories;


class DataRole implements \BristolSU\ControlDB\Contracts\Repositories\DataRole
{

    public function getById($id): \BristolSU\ControlDB\Contracts\Models\DataRole
    {
        return \BristolSU\ControlDB\Models\DataRole::findOrFail($id);
    }


    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataRole
    {
        return \BristolSU\ControlDB\Models\DataRole::where($attributes)->firstOrFail();
    }

    public function create(?string $roleName = null, ?string $email = null): \BristolSU\ControlDB\Contracts\Models\DataRole
    {
        return \BristolSU\ControlDB\Models\DataRole::create([
            'role_name' => $roleName,
            'email' => $email,
        ]);
    }
}