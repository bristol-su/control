<?php

namespace BristolSU\ControlDB\Cache;

use BristolSU\ControlDB\Contracts\Models\Group as GroupModel;
use BristolSU\ControlDB\Contracts\Repositories\Group as GroupRepositoryContract;
use BristolSU\ControlDB\Contracts\Repositories\Group as GroupRepository;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class Group implements GroupRepository
{
    /**
     * @var GroupRepositoryContract
     */
    private $groupRepository;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(GroupRepositoryContract $groupRepository, Repository $cache)
    {
        $this->groupRepository = $groupRepository;
        $this->cache = $cache;
    }

    /**
     * Get a group by ID
     *
     * @param int $id ID of the group
     * @return GroupModel
     */
    public function getById(int $id): GroupModel
    {
        return $this->cache->rememberForever(static::class . '@getById:' . $id, function() use ($id) {
            return $this->groupRepository->getById($id);
        });
    }

    /**
     * Get a group by its data provider ID
     *
     * @param int $dataProviderId
     * @return GroupModel
     */
    public function getByDataProviderId(int $dataProviderId): GroupModel
    {
        return $this->cache->rememberForever(static::class . '@getByDataProviderId:' . $dataProviderId, function() use ($dataProviderId) {
            return $this->groupRepository->getByDataProviderId($dataProviderId);
        });
    }

    /**
     * Get all groups
     *
     * @return Collection|GroupModel[]
     */
    public function all(): Collection
    {
        return $this->groupRepository->all();
    }

    /**
     * Create a new group
     *
     * @param int $dataProviderId
     * @return GroupModel
     */
    public function create(int $dataProviderId): GroupModel
    {
        return $this->groupRepository->create($dataProviderId);
    }

    /**
     * Delete a group by ID
     *
     * @param int $id
     */
    public function delete(int $id): void
    {
        $this->groupRepository->delete($id);
    }

    /**
     * Paginate through all the groups
     *
     * @param int $page The page number to return
     * @param int $perPage The number of results to return per page
     *
     * @return Collection|GroupModel[]
     */
    public function paginate(int $page, int $perPage): Collection
    {
        return $this->groupRepository->paginate($page, $perPage);
    }

    /**
     * Get the number of groups
     *
     * @return int
     */
    public function count(): int
    {
        return $this->cache->rememberForever(static::class . '@count', function() {
            return $this->groupRepository->count();
        });
    }

    /**
     * Update the group model
     *
     * @param int $id 
     * @param int $dataProviderId New data provider ID
     * @return GroupModel
     */
    public function update(int $id, int $dataProviderId): GroupModel
    {
        return $this->groupRepository->update($id, $dataProviderId);
    }
}