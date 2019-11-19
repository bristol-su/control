<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\Support\Control\Contracts\Models\User;
use BristolSU\Support\Control\Contracts\Models\Tags\UserTagCategory;
use BristolSU\Support\Control\Contracts\Repositories\Tags\UserTag as UserTagContract;
use Illuminate\Support\Collection;

/**
 * Class UserTag
 * @package BristolSU\ControlDB\Repositories
 */
class UserTag implements UserTagContract
{
    /**
     * Get all user tags
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\UserTag::all();
    }

    /**
     * Get all user tags which a user is tagged with
     *
     * @param User $user
     * @return Collection
     */
    public function allThroughUser(User $user): Collection
    {
        return $user->tags();
    }

    /**
     * Get a tag by the full reference
     *
     * @param string $reference
     * @return mixed
     */
    public function getTagByFullReference(string $reference): \BristolSU\Support\Control\Contracts\Models\Tags\UserTag
    {
        return $this->all()->filter(function(\BristolSU\ControlDB\Models\Tags\UserTag $tag) use ($reference) {
            return $reference === $tag->fullReference();
        })->firstOrFail();
    }

    /**
     * Get a user tag by id
     *
     * @param int $id
     * @return \BristolSU\Support\Control\Contracts\Models\Tags\UserTag
     */
    public function getById(int $id): \BristolSU\Support\Control\Contracts\Models\Tags\UserTag
    {
        return \BristolSU\ControlDB\Models\Tags\UserTag::findOrFail($id);
    }

    /**
     * Get all user tags belonging to a user tag category
     *
     * @param UserTagCategory $userTagCategory
     * @return Collection
     */
    public function allThroughUserTagCategory(UserTagCategory $userTagCategory): Collection
    {
        return $userTagCategory->tags();
    }
}
