<?php

namespace BristolSU\ControlDB\Cache;

use BristolSU\ControlDB\Contracts\Models\Role as RoleModel;
use BristolSU\ControlDB\Contracts\Repositories\Role as RoleRepositoryContract;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class Role implements RoleRepositoryContract
{

    /**
     * @var RoleRepositoryContract
     */
    private $roleRepository;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(RoleRepositoryContract $roleRepository, Repository $cache)
    {
        $this->roleRepository = $roleRepository;
        $this->cache = $cache;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): RoleModel
    {
        return $this->cache->rememberForever(static::class . '@getById:' . $id, function() use ($id) {
            return $this->roleRepository->getById($id);
        });
    }

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return $this->roleRepository->all();
    }

    /**
     * @inheritDoc
     */
    public function getByDataProviderId(int $dataProviderId): RoleModel
    {
        return $this->cache->rememberForever(static::class . '@getByDataProviderId:' . $dataProviderId, function() use ($dataProviderId) {
            return $this->roleRepository->getByDataProviderId($dataProviderId);
        });
    }

    /**
     * @inheritDoc
     */
    public function create(int $positionId, int $groupId, int $dataProviderId): RoleModel
    {
        return $this->roleRepository->create($positionId, $groupId, $dataProviderId);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): void
    {
        $this->roleRepository->delete($id);
    }

    /**
     * @inheritDoc
     */
    public function allThroughGroup(\BristolSU\ControlDB\Contracts\Models\Group $group): Collection
    {
        return $this->cache->rememberForever(static::class . '@allThroughGroup:' . $group->id(), function() use ($group) {
            return $this->roleRepository->allThroughGroup($group);
        });
    }

    /**
     * @inheritDoc
     */
    public function allThroughPosition(\BristolSU\ControlDB\Contracts\Models\Position $position): Collection
    {
        return $this->cache->rememberForever(static::class . '@allThroughPosition:' . $position->id(), function() use ($position) {
            return $this->roleRepository->allThroughPosition($position);
        });
    }

    /**
     * Paginate through all the roles
     *
     * @param int $page The page number to return
     * @param int $perPage The number of results to return per page
     *
     * @return Collection|RoleModel[]
     */
    public function paginate(int $page, int $perPage): Collection
    {
        return $this->roleRepository->paginate($page, $perPage);
    }

    /**
     * Get the number of roles
     *
     * @return int
     */
    public function count(): int
    {
        return $this->cache->rememberForever(static::class . '@count', function() {
            return $this->roleRepository->count();
        });
        
    }

    /**
     * Update the role model
     *
     * @param int $id
     * @param int $positionId
     * @param int $groupId
     * @param int $dataProviderId New data provider ID
     * @return RoleModel
     */
    public function update(int $id, int $positionId, int $groupId, int $dataProviderId): RoleModel
    {
        return $this->roleRepository->update($id, $positionId, $groupId, $dataProviderId);
    }
}