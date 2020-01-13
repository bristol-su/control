<?php


namespace BristolSU\ControlDB\Repositories;


class DataGroup implements \BristolSU\ControlDB\Contracts\Repositories\DataGroup
{

    public function getById($id): \BristolSU\ControlDB\Contracts\Models\DataGroup
    {
        return \BristolSU\ControlDB\Models\DataGroup::findOrFail($id);
    }


    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataGroup
    {
        return \BristolSU\ControlDB\Models\DataGroup::where($attributes)->firstOrFail();
    }

    public function create(?string $name = null, ?string $email = null): \BristolSU\ControlDB\Contracts\Models\DataGroup
    {
        return \BristolSU\ControlDB\Models\DataGroup::create([
            'name' => $name,
            'email' => $email,
        ]);
    }
}