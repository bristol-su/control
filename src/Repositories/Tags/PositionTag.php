<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Position;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag as PositionTagModel;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory;
use BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTag as PositionTagContract;
use Illuminate\Support\Collection;

/**
 * Class PositionTag
 * @package BristolSU\ControlDB\Repositories
 */
class PositionTag extends PositionTagContract
{

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\PositionTag::all();
    }

    /**
     * @inheritDoc
     */
    public function getTagByFullReference(string $reference): PositionTagModel
    {
        return \BristolSU\ControlDB\Models\Tags\PositionTag::where('reference', $reference)->get()->first();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): PositionTagModel
    {
        return \BristolSU\ControlDB\Models\Tags\PositionTag::where('id', $id)->get()->first();
    }
}
