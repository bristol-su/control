<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag as PositionTagModel;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory as PositionTagCategoryModel;
use BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTagCategory as PositionTagCategoryContract;
use Illuminate\Support\Collection;

/**
 * Class PositionTag
 * @package BristolSU\ControlDB\Repositories
 */
class PositionTagCategory extends PositionTagCategoryContract
{


    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\PositionTagCategory::all();
    }

    /**
     * @inheritDoc
     */
    public function getByReference(string $reference): PositionTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\PositionTagCategory::where('reference', $reference)->get()->first();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): PositionTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\PositionTagCategory::where('id', $id)->get()->first();
    }
}
