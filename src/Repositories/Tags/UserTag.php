<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\UserTag as UserTagModel;
use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory;
use BristolSU\ControlDB\Contracts\Repositories\Tags\UserTag as UserTagContract;
use Illuminate\Support\Collection;

/**
 * Class UserTag
 * @package BristolSU\ControlDB\Repositories
 */
class UserTag extends UserTagContract
{

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\UserTag::all();
    }

    /**
     * @inheritDoc
     */
    public function getTagByFullReference(string $reference): UserTagModel
    {
        return \BristolSU\ControlDB\Models\Tags\UserTag::where('reference', $reference)->get()->first();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): UserTagModel
    {
        return \BristolSU\ControlDB\Models\Tags\UserTag::where('id', $id)->get()->first();
    }
}
