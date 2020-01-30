<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Tags\UserTag as UserTagContract;
use BristolSU\ControlDB\Models\Tags\UserTag as UserTagModel;
use Illuminate\Support\Collection;

/**
 * Handles user tags
 */
class UserTag implements UserTagContract
{

    /**
     * Get all user tags
     *
     * @return Collection|\BristolSU\ControlDB\Contracts\Models\Tags\UserTag[]
     */
    public function all(): Collection
    {
        return UserTagModel::all();
    }

    /**
     * Get a tag by the full reference
     *
     * The full reference looks like 'tag_category_ref.tag_ref'
     *
     * @param string $reference
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\UserTag
     */
    public function getTagByFullReference(string $reference): \BristolSU\ControlDB\Contracts\Models\Tags\UserTag
    {
        $fullTagReference = explode('.', $reference);
        $categoryReference = $fullTagReference[0];
        $tagReference = $fullTagReference[1];
        $tagCategory = app(\BristolSU\ControlDB\Contracts\Repositories\Tags\UserTagCategory::class)->getByReference($categoryReference);

        return UserTagModel::where([
            'reference' => $tagReference,
            'tag_category_id' => $tagCategory->id()
        ])->firstOrFail();
    }

    /**
     * Get a user tag by id
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\UserTag
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\Tags\UserTag
    {
        return UserTagModel::where('id', $id)->firstOrFail();
    }

    /**
     * Create a user tag
     *
     * @param string $name Name of the tag
     * @param string $description Description of the tag
     * @param string $reference Reference for the tag
     * @param int $tagCategoryId Category ID of the tag
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\UserTag
     */
    public function create(string $name, string $description, string $reference, int $tagCategoryId): \BristolSU\ControlDB\Contracts\Models\Tags\UserTag
    {
        return \BristolSU\ControlDB\Models\Tags\UserTag::create([
            'name' => $name,
            'description' => $description,
            'reference' => $reference,
            'tag_category_id' => $tagCategoryId
        ]);
    }

    /**
     * Delete a user tag
     *
     * @param int $id ID of the tag to delete
     */
    public function delete(int $id): void
    {
        $this->getById($id)->delete();
    }

    /**
     * Get all tags through a tag category
     *
     * @param \BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory $userTagCategory
     * @return Collection|\BristolSU\ControlDB\Contracts\Repositories\Tags\UserTag[] Tags with the given user tag category
     */
    public function allThroughTagCategory(\BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory $userTagCategory): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\UserTag::where('tag_category_id', $userTagCategory->id())->get();
    }
}
