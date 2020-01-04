<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\UserTag as UserTagModel;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory as UserTagCategoryModel;
use BristolSU\ControlDB\Contracts\Repositories\Tags\UserTagCategory as UserTagCategoryContract;
use Illuminate\Support\Collection;

/**
 * Class UserTag
 * @package BristolSU\ControlDB\Repositories
 */
class UserTagCategory extends UserTagCategoryContract
{

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\UserTagCategory::all();
    }

    /**
     * @inheritDoc
     */
    public function getByReference(string $reference): UserTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\UserTagCategory::where('reference', $reference)->get()->first();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): UserTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\UserTagCategory::where('id', $id)->get()->first();
    }
}
