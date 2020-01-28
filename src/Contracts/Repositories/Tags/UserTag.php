<?php


namespace BristolSU\ControlDB\Contracts\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory as UserTagCategoryContract;
use BristolSU\ControlDB\Contracts\Models\User as UserContract;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTag as UserTagModel;
use Illuminate\Support\Collection;

/**
 * Interface UserTag
 */
interface UserTag
{

    /**
     * Get all user tags
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Get a tag by the full reference
     *
     * @param $reference
     * @return mixed
     */
    public function getTagByFullReference(string $reference): UserTagModel;

    /**
     * Get a user tag by id
     *
     * @param int $id
     * @return UserTagModel
     */
    public function getById(int $id): UserTagModel;

    public function create(string $name, string $description, string $reference, $tagCategoryId): UserTagModel;
    
    public function delete(int $id): void;

    public function allThroughTagCategory(\BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory $userTagCategory): Collection;


}
