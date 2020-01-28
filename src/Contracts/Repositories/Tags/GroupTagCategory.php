<?php


namespace BristolSU\ControlDB\Contracts\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag as GroupTagModel;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory as GroupTagCategoryModel;
use Illuminate\Support\Collection;

/**
 * Interface GroupTag
 * @package BristolSU\ControlDB\Contracts\Repositories
 */
interface GroupTagCategory
{

    /**
     * Get all group tag categories
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Get a tag category by the reference
     *
     * @param $reference
     * @return mixed
     */
    public function getByReference(string $reference): GroupTagCategoryModel;

    /**
     * Get a group tag category by id
     *
     * @param int $id
     * @return GroupTagCategoryModel
     */
    public function getById(int $id): GroupTagCategoryModel;

    public function delete(int $id): void;

    public function create(string $name, string $description, string $reference): GroupTagCategoryModel;
}
