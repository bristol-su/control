<?php

namespace BristolSU\ControlDB\Cache;

use BristolSU\ControlDB\Contracts\Repositories\DataGroup as DataGroupRepository;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class DataGroup implements DataGroupRepository
{

    /**
     * @var DataGroupRepository
     */
    private $dataGroupRepository;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(DataGroupRepository $dataGroupRepository, Repository $cache)
    {
        $this->dataGroupRepository = $dataGroupRepository;
        $this->cache = $cache;
    }

    /**
     * Get a data group by ID
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\DataGroup
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\DataGroup
    {
        return $this->cache->rememberForever(static::class . '@getById:' . $id, function() use ($id) {
            return $this->dataGroupRepository->getById($id);
        });
    }

    /**
     * Get a data group where the given attributes match, including additional attributes.
     *
     * @param array $attributes
     * @return \BristolSU\ControlDB\Contracts\Models\DataGroup
     */
    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataGroup
    {
        return $this->dataGroupRepository->getWhere($attributes);
    }
    
    /**
     * Get all data groups where the given attributes match, including additional attributes.
     *
     * @param array $attributes
     * @return Collection|\BristolSU\ControlDB\Contracts\Models\DataGroup[]
     */
    public function getAllWhere($attributes = []): Collection
    {
        return $this->dataGroupRepository->getAllWhere($attributes);
    }

    /**
     * Create a data group with the given attributes
     *
     * @param string|null $name Name of the group
     * @param string|null $email Email of the group
     *
     * @return \BristolSU\ControlDB\Contracts\Models\DataGroup
     */
    public function create(?string $name = null, ?string $email = null): \BristolSU\ControlDB\Contracts\Models\DataGroup
    {
        return $this->dataGroupRepository->create($name, $email);
    }

    /**
     * Update a group with the given attributes
     *
     * @param int $id
     * @param string|null $name Name of the group
     * @param string|null $email Email of the group
     * @return \BristolSU\ControlDB\Contracts\Models\DataGroup
     */
    public function update(int $id, ?string $name = null, ?string $email = null): \BristolSU\ControlDB\Contracts\Models\DataGroup
    {
        return $this->dataGroupRepository->update($id, $name, $email);
    }
}