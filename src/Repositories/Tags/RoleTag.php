<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTag as RoleTagContract;
use BristolSU\ControlDB\Models\Tags\RoleTag as RoleTagModel;
use Illuminate\Support\Collection;

/**
 * Handles role tags
 */
class RoleTag implements RoleTagContract
{

    /**
     * Get all role tags
     *
     * @return Collection|\BristolSU\ControlDB\Contracts\Models\Tags\RoleTag[]
     */
    public function all(): Collection
    {
        return RoleTagModel::all();
    }

    /**
     * Get a tag by the full reference
     *
     * The full reference looks like 'tag_category_ref.tag_ref'
     *
     * @param string $reference
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\RoleTag
     */
    public function getTagByFullReference(string $reference): \BristolSU\ControlDB\Contracts\Models\Tags\RoleTag
    {
        $fullTagReference = explode('.', $reference);
        $categoryReference = $fullTagReference[0];
        $tagReference = $fullTagReference[1];
        $tagCategory = app(\BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTagCategory::class)->getByReference($categoryReference);

        return RoleTagModel::where([
            'reference' => $tagReference,
            'tag_category_id' => $tagCategory->id()
        ])->firstOrFail();
    }

    /**
     * Get a role tag by id
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\RoleTag
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\Tags\RoleTag
    {
        return RoleTagModel::where('id', $id)->firstOrFail();
    }

    /**
     * Create a role tag
     *
     * @param string $name Name of the tag
     * @param string $description Description of the tag
     * @param string $reference Reference for the tag
     * @param int $tagCategoryId Category ID of the tag
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\RoleTag
     */
    public function create(string $name, string $description, string $reference, int $tagCategoryId): \BristolSU\ControlDB\Contracts\Models\Tags\RoleTag
    {
        return \BristolSU\ControlDB\Models\Tags\RoleTag::create([
            'name' => $name,
            'description' => $description,
            'reference' => $reference,
            'tag_category_id' => $tagCategoryId
        ]);
    }

    /**
     * Delete a role tag
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
     * @param \BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory $roleTagCategory
     * @return Collection|\BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTag[] Tags with the given role tag category
     */
    public function allThroughTagCategory(\BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory $roleTagCategory): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\RoleTag::where('tag_category_id', $roleTagCategory->id())->get();
    }
}
