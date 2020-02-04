<?php

namespace BristolSU\ControlDB\Contracts\Repositories;

/**
 * Handle attributes of a position
 */
interface DataPosition
{

    /**
     * Get a data position by ID
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\DataPosition
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\DataPosition;

    /**
     * Get a data position where the given attributes match, including additional attributes.
     *
     * @param array $attributes
     * @return \BristolSU\ControlDB\Contracts\Models\DataPosition
     */
    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataPosition;

    /**
     * Create a data position with the given attributes
     * 
     * @param string|null $name Name of the position
     * @param string|null $description Description of the position
     * @return \BristolSU\ControlDB\Contracts\Models\DataPosition
     */
    public function create(?string $name = null, ?string $description = null): \BristolSU\ControlDB\Contracts\Models\DataPosition;
}