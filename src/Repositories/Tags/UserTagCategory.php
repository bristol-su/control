<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\Support\Control\Contracts\Models\Tags\UserTag as UserTagModel;
use BristolSU\Support\Control\Contracts\Models\Tags\UserTagCategory as UserTagCategoryModel;
use BristolSU\Support\Control\Contracts\Repositories\Tags\UserTagCategory as UserTagCategoryContract;
use Illuminate\Support\Collection;

/**
 * Class UserTag
 * @package BristolSU\ControlDB\Repositories
 */
class UserTagCategory implements UserTagCategoryContract
{

    /**
     * Get all user tag categories
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\UserTagCategory::all();
    }

    /**
     * Get the user tag category of a user tag
     *
     * @param UserTagModel $user
     * @return UserTagCategoryModel
     */
    public function allThroughTag(UserTagModel $userTag): UserTagCategoryModel
    {
        // TODO this method should be changed to getThroughUserTag
        return $userTag->category();
    }

    /**
     * Get a tag category by the reference
     *
     * @param $reference
     * @return mixed
     */
    public function getByReference(string $reference): UserTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\UserTagCategory::where('reference', $reference)->firstOrFail();
    }

    /**
     * Get a user tag category by id
     *
     * @param int $id
     * @return UserTagCategoryModel
     */
    public function getById(int $id): UserTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\UserTagCategory::findOrFail($id);
    }
}
