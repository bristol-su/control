<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag as GroupTagModel;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory as GroupTagCategoryModel;
use BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTagCategory as GroupTagCategoryContract;
use Illuminate\Support\Collection;

/**
 * Class GroupTag
 * @package BristolSU\ControlDB\Repositories
 */

class GroupTagCategory extends GroupTagCategoryContract
{

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\GroupTagCategory::all();
    }

    /**
     * @inheritDoc
     */
    public function getByReference(string $reference): GroupTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\GroupTagCategory::where('reference', $reference)->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): GroupTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\GroupTagCategory::where('id', $id)->firstOrFail();
    }
}
