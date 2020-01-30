<?php

namespace BristolSU\ControlDB\Contracts\Repositories;

use BristolSU\ControlDB\Contracts\Models\User as UserModel;
use Illuminate\Support\Collection;

/**
 * Handles users
 */
interface User
{
    /**
     * Get a user by ID
     *
     * @param int $id ID of the user
     * @return UserModel
     */
    public function getById(int $id): UserModel;

    /**
     * Get a user by its data provider ID
     *
     * @param int $dataProviderId
     * @return UserModel
     */
    public function getByDataProviderId(int $dataProviderId): UserModel;

    /**
     * Get all users
     *
     * @return Collection|UserModel[]
     */
    public function all(): Collection;

    /**
     * Create a new user
     *
     * @param int $dataProviderId
     * @return UserModel
     */
    public function create(int $dataProviderId): UserModel;

    /**
     * Delete a user by ID
     *
     * @param int $id
     */
    public function delete(int $id): void;
}
