<?php

namespace BristolSU\ControlDB\Contracts\Repositories;

use BristolSU\ControlDB\Contracts\Models\User as UserModel;
use BristolSU\ControlDB\Contracts\Models\Group as GroupModel;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag as GroupTagModel;
use Illuminate\Support\Collection;

/**
 * Interface Group
 */
interface Group
{

    /**
     * Get a group by ID
     *
     * @param $id
     * @return GroupModel
     */
    public function getById(int $id): GroupModel;

    public function getByDataProviderId($dataProviderId): GroupModel;

    /**
     * Get all groups
     *
     * @return Collection
     */
    public function all(): Collection;

    public function create(int $dataProviderId): GroupModel;
    
    public function delete(int $id): void;

}
