<?php


namespace BristolSU\ControlDB\Contracts\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag as PositionTagModel;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory as PositionTagCategoryModel;
use Illuminate\Support\Collection;

/**
 * Interface PositionTag
 * @package BristolSU\ControlDB\Contracts\Repositories
 */
interface PositionTagCategory
{

    /**
     * Get all position tag categories
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
    public function getByReference(string $reference): PositionTagCategoryModel;

    /**
     * Get a position tag category by id
     *
     * @param int $id
     * @return PositionTagCategoryModel
     */
    public function getById(int $id): PositionTagCategoryModel;

    public function delete(int $id): void;

    public function create(string $name, string $description, string $reference): PositionTagCategoryModel;
}
