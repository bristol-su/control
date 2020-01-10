<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag as PositionTagModelContract;
use BristolSU\ControlDB\Models\Tags\PositionTag as PositionTagModel;
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
        return PositionTagModel::all();
    }

    /**
     * @inheritDoc
     */
    public function getTagByFullReference(string $reference): PositionTagModelContract
    {
        $fullTagReference = explode('.', $reference);
        $categoryReference = $fullTagReference[0];
        $tagReference = $fullTagReference[1];

        return PositionTagModel::where('reference', $tagReference)->whereHas('categoryRelationship', function($builder) use ($categoryReference) {
            $builder->where('reference', $categoryReference);
        })->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): PositionTagModelContract
    {
        return PositionTagModel::where('id', $id)->firstOrFail();
    }
}
