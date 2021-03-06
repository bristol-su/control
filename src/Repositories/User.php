<?php

namespace BristolSU\ControlDB\Repositories;

use BristolSU\ControlDB\Contracts\Models\User as UserModel;
use BristolSU\ControlDB\Contracts\Repositories\User as UserContract;
use Illuminate\Support\Collection;

/**
 * Handles users
 */
class User implements UserContract
{

    /**
     * Get a user by ID
     *
     * @param int $id ID of the user
     * @return UserModel
     */
    public function getById(int $id): UserModel
    {
        return \BristolSU\ControlDB\Models\User::findOrFail($id);
    }

    /**
     * Get all users
     *
     * @return Collection|UserModel[]
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\User::all();
    }

    /**
     * Create a new user
     *
     * @param int $dataProviderId
     * @return UserModel
     */
    public function create(int $dataProviderId): UserModel
    {
        return \BristolSU\ControlDB\Models\User::create([
            'data_provider_id' => $dataProviderId
        ]);
    }

    /**
     * Delete a user by ID
     *
     * @param int $id
     */
    public function delete(int $id): void
    {
        \BristolSU\ControlDB\Models\User::findOrFail($id)->delete();
    }

    /**
     * Get a user by its data provider ID
     *
     * @param int $dataProviderId
     * @return UserModel
     */
    public function getByDataProviderId(int $dataProviderId): UserModel {
        return \BristolSU\ControlDB\Models\User::where('data_provider_id', $dataProviderId)->firstOrFail();
    }

    /**
     * Paginate through all the users
     *
     * @param int $page The page number to return
     * @param int $perPage The number of results to return per page
     *
     * @return Collection|UserModel[]
     */
    public function paginate(int $page, int $perPage): Collection
    {
        return \BristolSU\ControlDB\Models\User::paginate($perPage, ['*'], 'page', $page)->getCollection();
    }

    /**
     * Get the number of users
     *
     * @return int
     */
    public function count(): int
    {
        return \BristolSU\ControlDB\Models\User::count();
    }


    /**
     * Update the user model
     *
     * @param int $id
     * @param int $dataProviderId New data provider ID
     * @return UserModel
     */
    public function update(int $id, int $dataProviderId): UserModel
    {
        $user = $this->getById($id)->fill(['data_provider_id' => $dataProviderId]);
        $user->save();
        return $user;
    }
}
