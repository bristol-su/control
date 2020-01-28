<?php


namespace BristolSU\ControlDB\Contracts\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Group;
use Illuminate\Support\Collection;

/**
 * Interface GroupTag
 * @package BristolSU\ControlDB\Contracts\Repositories
 */
interface GroupTag
{

    /**
     * Get all group tags
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Get a tag by the full reference
     *
     * The full reference looks like 'tag_category_ref.tag_ref'
     *
     * @param string $reference
     * @return mixed
     */
    public function getTagByFullReference(string $reference): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;

    /**
     * Get a group tag by id
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;

    public function create(string $name, string $description, string $reference, $tagCategoryId): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;

    public function delete(int $id): void;

    public function allThroughTagCategory(\BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory $groupTagCategory): Collection;
}
