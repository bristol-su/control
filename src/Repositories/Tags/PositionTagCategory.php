<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\Support\Control\Contracts\Models\Tags\PositionTag as PositionTagModel;
use BristolSU\Support\Control\Contracts\Models\Tags\PositionTagCategory as PositionTagCategoryModel;
use BristolSU\Support\Control\Contracts\Repositories\Tags\PositionTagCategory as PositionTagCategoryContract;
use Illuminate\Support\Collection;

/**
 * Class PositionTag
 * @package BristolSU\ControlDB\Repositories
 */
class PositionTagCategory implements PositionTagCategoryContract
{

    /**
     * Get all position tag categories
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\PositionTagCategory::all();
    }

    /**
     * Get the position tag category of a position tag
     *
     * @param PositionTagModel $position
     * @return PositionTagCategoryModel
     */
    public function allThroughTag(PositionTagModel $positionTag): PositionTagCategoryModel
    {
        // TODO this method should be changed to getThroughPositionTag
        return $positionTag->category();
    }

    /**
     * Get a tag category by the reference
     *
     * @param $reference
     * @return mixed
     */
    public function getByReference(string $reference): PositionTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\PositionTagCategory::where('reference', $reference)->firstOrFail();
    }

    /**
     * Get a position tag category by id
     *
     * @param int $id
     * @return PositionTagCategoryModel
     */
    public function getById(int $id): PositionTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\PositionTagCategory::findOrFail($id);
    }

}
