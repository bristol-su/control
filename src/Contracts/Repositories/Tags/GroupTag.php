<?php


namespace BristolSU\ControlDB\Contracts\Repositories\Tags;

use Illuminate\Support\Collection;

/**
 * Manages group tags
 */
interface GroupTag
{

    /**
     * Get all group tags
     *
     * @return Collection|\BristolSU\ControlDB\Contracts\Models\Tags\GroupTag[]
     */
    public function all(): Collection;

    /**
     * Get a tag by the full reference
     *
     * The full reference looks like 'tag_category_ref.tag_ref'
     *
     * @param string $reference
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
     */
    public function getTagByFullReference(string $reference): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;

    /**
     * Get a group tag by id
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;

    /**
     * Create a group tag
     * 
     * @param string $name Name of the tag
     * @param string $description Description of the tag
     * @param string $reference Reference for the tag
     * @param int $tagCategoryId Category ID of the tag
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
     */
    public function create(string $name, string $description, string $reference, int $tagCategoryId): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;

    /**
     * Update a group tag
     *
     * @param int $id
     * @param string $name Name of the tag
     * @param string $description Description of the tag
     * @param string $reference Reference for the tag
     * @param int $tagCategoryId Category ID of the tag
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
     */
    public function update(int $id, string $name, string $description, string $reference, int $tagCategoryId): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;

    /**
     * Delete a group tag
     * 
     * @param int $id ID of the tag to delete
     */
    public function delete(int $id): void;

    /**
     * Get all tags through a tag category
     * 
     * @param \BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory $groupTagCategory
     * @return Collection|\BristolSU\ControlDB\Contracts\Models\Tags\GroupTag[] Tags with the given group tag category
     */
    public function allThroughTagCategory(\BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory $groupTagCategory): Collection;
}
