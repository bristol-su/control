<?php


namespace BristolSU\ControlDB\Contracts\Repositories\Tags;

use Illuminate\Support\Collection;

/**
 * Manages position tags
 */
interface PositionTag
{

    /**
     * Get all position tags
     *
     * @return Collection|\BristolSU\ControlDB\Contracts\Models\Tags\PositionTag[]
     */
    public function all(): Collection;

    /**
     * Get a tag by the full reference
     *
     * The full reference looks like 'tag_category_ref.tag_ref'
     *
     * @param string $reference
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag
     */
    public function getTagByFullReference(string $reference): \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag;

    /**
     * Get a position tag by id
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag;

    /**
     * Create a position tag
     *
     * @param string $name Name of the tag
     * @param string $description Description of the tag
     * @param string $reference Reference for the tag
     * @param int $tagCategoryId Category ID of the tag
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag
     */
    public function create(string $name, string $description, string $reference, int $tagCategoryId): \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag;

    /**
     * Delete a position tag
     *
     * @param int $id ID of the tag to delete
     */
    public function delete(int $id): void;

    /**
     * Get all tags through a tag category
     *
     * @param \BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory $positionTagCategory
     * @return Collection|PositionTag[] Tags with the given position tag category
     */
    public function allThroughTagCategory(\BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory $positionTagCategory): Collection;
}
