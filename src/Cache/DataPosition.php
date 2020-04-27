<?php

namespace BristolSU\ControlDB\Cache;

use BristolSU\ControlDB\Contracts\Repositories\DataPosition as DataPositionRepository;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class DataPosition implements DataPositionRepository
{

    /**
     * @var DataPositionRepository
     */
    private $dataPositionRepository;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(DataPositionRepository $dataPositionRepository, Repository $cache)
    {
        $this->dataPositionRepository = $dataPositionRepository;
        $this->cache = $cache;
    }

    /**
     * Get a data position by ID
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\DataPosition
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\DataPosition
    {
        return $this->cache->rememberForever(static::class . '@getById:' . $id, function() use ($id) {
            return $this->dataPositionRepository->getById($id);
        });
    }

    /**
     * Get a data position where the given attributes match, including additional attributes.
     *
     * @param array $attributes
     * @return \BristolSU\ControlDB\Contracts\Models\DataPosition
     */
    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataPosition
    {
        return $this->dataPositionRepository->getWhere($attributes);
    }
    
    /**
     * Get all data positions where the given attributes match, including additional attributes.
     *
     * @param array $attributes
     * @return Collection|\BristolSU\ControlDB\Contracts\Models\DataPosition[]
     */
    public function getAllWhere($attributes = []): Collection
    {
        return $this->dataPositionRepository->getAllWhere($attributes);
    }


    /**
     * Create a data position with the given attributes
     *
     * @param string|null $name Name of the position
     * @param string|null $description Description of the position
     * @return \BristolSU\ControlDB\Contracts\Models\DataPosition
     */
    public function create(?string $name = null, ?string $description = null): \BristolSU\ControlDB\Contracts\Models\DataPosition
    {
        return $this->dataPositionRepository->create($name, $description);
    }

    /**
     * Update a data position with the given attributes
     *
     * @param int $id
     * @param string|null $name Name of the position
     * @param string|null $description Description of the position
     * @return \BristolSU\ControlDB\Contracts\Models\DataPosition
     */
    public function update(int $id, ?string $name = null, ?string $description = null): \BristolSU\ControlDB\Contracts\Models\DataPosition
    {
        return $this->dataPositionRepository->update($id, $name, $description);
    }
}