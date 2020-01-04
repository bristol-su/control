<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory;
use BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTag as GroupTagContract;
use BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTagModel;
use Illuminate\Support\Collection;

/**
 * Class GroupTag
 * @package BristolSU\ControlDB\Repositories
 */
class GroupTag extends GroupTagContract
{

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\GroupTag::all();
    }

    /**
     * @inheritDoc
     */
    public function getTagByFullReference(string $reference): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
    {
        return \BristolSU\ControlDB\Models\Tags\GroupTag::where('reference', $reference)->get()->first();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
    {
        return \BristolSU\ControlDB\Models\Tags\GroupTag::where('id', $id)->get()->first();
    }
}
