<?php

namespace BristolSU\ControlDB\Cache;

use BristolSU\ControlDB\Contracts\Models\Position as PositionModel;
use BristolSU\ControlDB\Contracts\Models\User as UserModel;
use BristolSU\ControlDB\Contracts\Repositories\Position as PositionRepositoryContract;
use BristolSU\ControlDB\Contracts\Repositories\Position as PositionRepository;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class Position implements PositionRepository
{
    /**
     * @var PositionRepositoryContract
     */
    private $positionRepository;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(PositionRepositoryContract $positionRepository, Repository $cache)
    {
        $this->positionRepository = $positionRepository;
        $this->cache = $cache;
    }

    /**
     * Get a position by ID
     *
     * @param int $id ID of the position
     * @return PositionModel
     */
    public function getById(int $id): PositionModel
    {
        return $this->cache->rememberForever(static::class . '@getById:' . $id, function() use ($id) {
            return $this->positionRepository->getById($id);
        });
    }

    /**
     * Get a position by its data provider ID
     *
     * @param int $dataProviderId
     * @return PositionModel
     */
    public function getByDataProviderId(int $dataProviderId): PositionModel
    {
        return $this->cache->rememberForever(static::class . '@getByDataProviderId:' . $dataProviderId, function() use ($dataProviderId) {
            return $this->positionRepository->getByDataProviderId($dataProviderId);
        });
    }

    /**
     * Get all positions
     *
     * @return Collection|PositionModel[]
     */
    public function all(): Collection
    {
        return $this->positionRepository->all();
    }

    /**
     * Create a new position
     *
     * @param int $dataProviderId
     * @return PositionModel
     */
    public function create(int $dataProviderId): PositionModel
    {
        return $this->positionRepository->create($dataProviderId);
    }

    /**
     * Delete a position by ID
     *
     * @param int $id
     */
    public function delete(int $id): void
    {
        $this->positionRepository->delete($id);
    }

    /**
     * Paginate through all the positions
     *
     * @param int $page The page number to return
     * @param int $perPage The number of results to return per page
     *
     * @return Collection|PositionModel[]
     */
    public function paginate(int $page, int $perPage): Collection
    {
        return $this->positionRepository->paginate($page, $perPage);
    }

    /**
     * Get the number of positions
     *
     * @return int
     */
    public function count(): int
    {
        return $this->cache->rememberForever(static::class . '@count', function() {
            return $this->positionRepository->count();
        });
    }

    /**
     * Update the position model
     *
     * @param int $id
     * @param int $dataProviderId New data provider ID
     * @return PositionModel
     */
    public function update(int $id, int $dataProviderId): PositionModel
    {
        return $this->positionRepository->update($id, $dataProviderId);
    }
}