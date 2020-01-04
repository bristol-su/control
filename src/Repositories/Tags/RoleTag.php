<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag as RoleTagModel;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory;
use BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTag as RoleTagContract;
use Illuminate\Support\Collection;

/**
 * Class RoleTag
 * @package BristolSU\ControlDB\Repositories
 */
class RoleTag extends RoleTagContract
{

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\RoleTag::all();
    }

    /**
     * @inheritDoc
     */
    public function getTagByFullReference(string $reference): RoleTagModel
    {
        return \BristolSU\ControlDB\Models\Tags\RoleTag::where('reference', $reference)->get()->first();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): RoleTagModel
    {
        return \BristolSU\ControlDB\Models\Tags\RoleTag::where('id', $id)->get()->first();
    }
}
