<?php

namespace BristolSU\ControlDB\Contracts\Repositories;

/**
 * Handle attributes of a role
 */
interface DataRole
{

    /**
     * Get a data role by ID
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\DataRole
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\DataRole;

    /**
     * Get a data role where the given attributes match, including additional attributes.
     *
     * @param array $attributes
     * @return \BristolSU\ControlDB\Contracts\Models\DataRole
     */
    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataRole;

    /**
     * Create a data position with the given attributes
     * 
     * @param string|null $roleName Custom name for the role
     * @param string|null $email Email of the role
     * @return \BristolSU\ControlDB\Contracts\Models\DataRole
     */
    public function create(?string $roleName = null, ?string $email = null): \BristolSU\ControlDB\Contracts\Models\DataRole;
}