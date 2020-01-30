<?php

namespace BristolSU\ControlDB\Repositories;

class DataGroup implements \BristolSU\ControlDB\Contracts\Repositories\DataGroup
{

    /**
     * Get a data group by ID
     * 
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\DataGroup
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\DataGroup
    {
        return \BristolSU\ControlDB\Models\DataGroup::findOrFail($id);
    }

    /**
     * Get a data group with the given attributes
     * 
     * @param array $attributes
     * @return \BristolSU\ControlDB\Contracts\Models\DataGroup
     */
    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataGroup
    {
        return \BristolSU\ControlDB\Models\DataGroup::where($attributes)->firstOrFail();
    }

    /**
     * Create a new data group
     * 
     * @param string|null $name
     * @param string|null $email
     * @return \BristolSU\ControlDB\Contracts\Models\DataGroup
     */
    public function create(?string $name = null, ?string $email = null): \BristolSU\ControlDB\Contracts\Models\DataGroup
    {
        return \BristolSU\ControlDB\Models\DataGroup::create([
            'name' => $name,
            'email' => $email,
        ]);
    }
}