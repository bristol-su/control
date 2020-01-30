<?php

namespace BristolSU\ControlDB\Contracts\Repositories;

/**
 * Handle attributes of a group
 */
interface DataGroup
{

    /**
     * Get a data group by ID
     * 
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\DataGroup
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\DataGroup;

    /**
     * Get a data group where the given attributes match
     * 
     * @param array $attributes
     * @return \BristolSU\ControlDB\Contracts\Models\DataGroup
     */
    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataGroup;

    /**
     * Create a group with the given attributes
     * 
     * @param string|null $name Name of the group
     * @param string|null $email Email of the group
     * @return \BristolSU\ControlDB\Contracts\Models\DataGroup
     */
    public function create(?string $name = null, ?string $email = null): \BristolSU\ControlDB\Contracts\Models\DataGroup;
}