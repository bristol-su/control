<?php


namespace BristolSU\ControlDB\Repositories;


class DataPosition implements \BristolSU\ControlDB\Contracts\Repositories\DataPosition
{

    /**
     * Get a data position by ID
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\DataPosition
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\DataPosition
    {
        return \BristolSU\ControlDB\Models\DataPosition::findOrFail($id);
    }

    /**
     * Get a data position with the given attributes
     *
     * @param array $attributes
     * @return \BristolSU\ControlDB\Contracts\Models\DataPosition
     */
    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataPosition
    {
        return \BristolSU\ControlDB\Models\DataPosition::where($attributes)->firstOrFail();
    }

    /**
     * Create a new data position
     *
     * @param string|null $name
     * @param string|null $description
     * @return \BristolSU\ControlDB\Contracts\Models\DataPosition
     */
    public function create(?string $name = null, ?string $description = null): \BristolSU\ControlDB\Contracts\Models\DataPosition
    {
        return \BristolSU\ControlDB\Models\DataPosition::create([
            'name' => $name,
            'description' => $description,
        ]);
    }
}