<?php


namespace BristolSU\ControlDB\Repositories;


class DataPosition implements \BristolSU\ControlDB\Contracts\Repositories\DataPosition
{

    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\DataPosition
    {
        return \BristolSU\ControlDB\Models\DataPosition::findOrFail($id);
    }


    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataPosition
    {
        return \BristolSU\ControlDB\Models\DataPosition::where($attributes)->firstOrFail();
    }

    public function create(?string $name = null, ?string $description = null): \BristolSU\ControlDB\Contracts\Models\DataPosition
    {
        return \BristolSU\ControlDB\Models\DataPosition::create([
            'name' => $name,
            'description' => $description,
        ]);
    }
}