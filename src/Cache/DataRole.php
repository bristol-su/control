<?php

namespace BristolSU\ControlDB\Cache;

use BristolSU\ControlDB\Contracts\Repositories\DataRole as DataRoleRepository;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class DataRole implements DataRoleRepository
{

    /**
     * @var DataRoleRepository
     */
    private $dataRoleRepository;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(DataRoleRepository $dataRoleRepository, Repository $cache)
    {
        $this->dataRoleRepository = $dataRoleRepository;
        $this->cache = $cache;
    }

    /**
     * Get a data role by ID
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\DataRole
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\DataRole
    {
        return $this->cache->rememberForever(static::class . '@getById:' . $id, function() use ($id) {
            return $this->dataRoleRepository->getById($id);
        });
    }

    /**
     * Get a data role where the given attributes match, including additional attributes.
     *
     * @param array $attributes
     * @return \BristolSU\ControlDB\Contracts\Models\DataRole
     */
    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataRole
    {
        return $this->dataRoleRepository->getWhere($attributes);
    }
    
    /**
     * Get all data roles where the given attributes match, including additional attributes.
     *
     * @param array $attributes
     * @return Collection|\BristolSU\ControlDB\Contracts\Models\DataRole[]
     */
    public function getAllWhere($attributes = []): Collection
    {
        return $this->dataRoleRepository->getAllWhere($attributes);
    }

    /**
     * Create a data position with the given attributes
     *
     * @param string|null $roleName Custom name for the role
     * @param string|null $email Email of the role
     * @return \BristolSU\ControlDB\Contracts\Models\DataRole
     */
    public function create(?string $roleName = null, ?string $email = null): \BristolSU\ControlDB\Contracts\Models\DataRole
    {
        return $this->dataRoleRepository->create($roleName, $email);
    }

    /**
     * Update a data position with the given attributes
     *
     * @param int $id
     * @param string|null $roleName Custom name for the role
     * @param string|null $email Email of the role
     * @return \BristolSU\ControlDB\Contracts\Models\DataRole
     */
    public function update(int $id, ?string $roleName = null, ?string $email = null): \BristolSU\ControlDB\Contracts\Models\DataRole
    {
        return $this->dataRoleRepository->update($id, $roleName, $email);
    }
}