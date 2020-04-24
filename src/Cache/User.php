<?php

namespace BristolSU\ControlDB\Cache;

use BristolSU\ControlDB\Contracts\Models\User as UserModel;
use BristolSU\ControlDB\Contracts\Repositories\User as UserRepositoryContract;
use BristolSU\ControlDB\Contracts\Repositories\User as UserRepository;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class User implements UserRepository
{
    /**
     * @var UserRepositoryContract
     */
    private $userRepository;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(UserRepositoryContract $userRepository, Repository $cache)
    {
        $this->userRepository = $userRepository;
        $this->cache = $cache;
    }

    /**
     * Get a user by ID
     *
     * @param int $id ID of the user
     * @return UserModel
     */
    public function getById(int $id): UserModel
    {
        return $this->cache->rememberForever(static::class . '@getById:' . $id, function() use ($id) {
            return $this->userRepository->getById($id);
        });
    }

    /**
     * Get a user by its data provider ID
     *
     * @param int $dataProviderId
     * @return UserModel
     */
    public function getByDataProviderId(int $dataProviderId): UserModel
    {
        return $this->cache->rememberForever(static::class . '@getByDataProviderId:' . $dataProviderId, function() use ($dataProviderId) {
            return $this->userRepository->getByDataProviderId($dataProviderId);
        });
    }

    /**
     * Get all users
     *
     * @return Collection|UserModel[]
     */
    public function all(): Collection
    {
        return $this->userRepository->all();
    }

    /**
     * Create a new user
     *
     * @param int $dataProviderId
     * @return UserModel
     */
    public function create(int $dataProviderId): UserModel
    {
        return $this->userRepository->create($dataProviderId);
    }

    /**
     * Delete a user by ID
     *
     * @param int $id
     */
    public function delete(int $id): void
    {
        $this->userRepository->delete($id);
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
        return $this->userRepository->paginate($page, $perPage);
    }

    /**
     * Get the number of users
     *
     * @return int
     */
    public function count(): int
    {
        return $this->cache->rememberForever(static::class . '@count', function() {
            return $this->userRepository->count();
        });
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
        return $this->userRepository->update($id, $dataProviderId);
    }
}