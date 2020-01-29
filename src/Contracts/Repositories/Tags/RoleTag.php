<?php


namespace BristolSU\ControlDB\Contracts\Repositories\Tags;

use Illuminate\Support\Collection;

/**
 * Manages role tags
 */
interface RoleTag
{

    /**
     * Get all role tags
     *
     * @return Collection|\BristolSU\ControlDB\Contracts\Models\Tags\RoleTag[]
     */
    public function all(): Collection;

    /**
     * Get a tag by the full reference
     *
     * The full reference looks like 'tag_category_ref.tag_ref'
     *
     * @param string $reference
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\RoleTag
     */
    public function getTagByFullReference(string $reference): \BristolSU\ControlDB\Contracts\Models\Tags\RoleTag;

    /**
     * Get a role tag by id
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\RoleTag
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\Tags\RoleTag;

    /**
     * Create a role tag
     *
     * @param string $name Name of the tag
     * @param string $description Description of the tag
     * @param string $reference Reference for the tag
     * @param int $tagCategoryId Category ID of the tag
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\RoleTag
     */
    public function create(string $name, string $description, string $reference, int $tagCategoryId): \BristolSU\ControlDB\Contracts\Models\Tags\RoleTag;

    /**
     * Delete a role tag
     *
     * @param int $id ID of the tag to delete
     */
    public function delete(int $id): void;

    /**
     * Get all tags through a tag category
     *
     * @param \BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory $roleTagCategory
     * @return Collection|RoleTag[] Tags with the given role tag category
     */
    public function allThroughTagCategory(\BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory $roleTagCategory): Collection;
}
