<?php


namespace BristolSU\ControlDB\Contracts\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag as PositionTagModel;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory as PositionTagCategoryModel;
use Illuminate\Support\Collection;

/**
 * Interface PositionTag
 * @package BristolSU\ControlDB\Contracts\Repositories
 */
abstract class PositionTagCategory
{

    /**
     * Get all position tag categories
     *
     * @return Collection
     */
    abstract public function all(): Collection;

    /**
     * Get the position tag category of a position tag
     *
     * @param PositionTagModel $position
     * @return PositionTagCategoryModel
     */
    public function getThroughTag(PositionTagModel $position): PositionTagCategoryModel {
        return $position->category();
    }

    /**
     * Get a tag category by the reference
     *
     * @param $reference
     * @return mixed
     */
    abstract public function getByReference(string $reference): PositionTagCategoryModel;

    /**
     * Get a position tag category by id
     *
     * @param int $id
     * @return PositionTagCategoryModel
     */
    abstract public function getById(int $id): PositionTagCategoryModel;
}
