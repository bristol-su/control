<?php


namespace BristolSU\ControlDB\Repositories;


use BristolSU\ControlDB\Models\Group as GroupModel;
use BristolSU\ControlDB\Models\Position as PositionModel;
use BristolSU\ControlDB\Models\Role as RoleModel;
use BristolSU\ControlDB\Models\User as UserModel;
use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\Position;
use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Contracts\Repositories\Role as RoleContract;
use Illuminate\Support\Collection;

/**
 * Class Role
 * @package BristolSU\ControlDB\Repositories
 */
class Role extends RoleContract
{


    /**
     * @inheritDoc
     */
    public function getById($id): \BristolSU\ControlDB\Contracts\Models\Role
    {
        return \BristolSU\ControlDB\Models\Role::where('id', $id)->get()->first();
    }

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Role::all();
    }
}
