<?php

namespace BristolSU\ControlDB\Repositories;

use BristolSU\ControlDB\Contracts\Models\Group as GroupModel;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;
use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Contracts\Repositories\Group as GroupContract;
use Illuminate\Support\Collection;

/**
 * Class Group
 * @package BristolSU\ControlDB\Repositories
 */
class Group extends GroupContract
{

    /**
     * @inheritDoc
     */
    public function getById(int $id): GroupModel
    {
        return \BristolSU\ControlDB\Models\Group::where('id', $id)->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Group::all();
    }
}
