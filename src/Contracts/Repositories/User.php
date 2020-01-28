<?php


namespace BristolSU\ControlDB\Contracts\Repositories;


use BristolSU\ControlDB\Contracts\Models\User as UserModelContract;
use Illuminate\Support\Collection;

/**
 * Interface User
 */
interface User
{

    /**
     * Get a user by their ID
     *
     * @param $id
     * @return UserModelContract
     */
    public function getById(int $id): UserModelContract;

    /**
     * Get all users
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Create a user
     *
     * @param $dataProviderId
     * @return UserModelContract
     */
    public function create($dataProviderId): UserModelContract;

    public function getByDataProviderId($dataProviderId): UserModelContract;
    
    public function delete(int $id): void;
}
