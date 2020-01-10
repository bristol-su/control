<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\ControlDB\Models\Tags\UserTag as UserTagModel;
use BristolSU\ControlDB\Contracts\Repositories\Tags\UserTag as UserTagContract;
use Illuminate\Support\Collection;

/**
 * Class UserTag
 * @package BristolSU\ControlDB\Repositories
 */
class UserTag extends UserTagContract
{

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return UserTagModel::all();
    }

    /**
     * @inheritDoc
     */
    public function getTagByFullReference(string $reference): \BristolSU\ControlDB\Contracts\Models\Tags\UserTag
    {
        $fullTagReference = explode('.', $reference);
        $categoryReference = $fullTagReference[0];
        $tagReference = $fullTagReference[1];

        return UserTagModel::where('reference', $tagReference)->whereHas('categoryRelationship', function($builder) use ($categoryReference) {
            $builder->where('reference', $categoryReference);
        })->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\Tags\UserTag
    {
        return UserTagModel::where('id', $id)->firstOrFail();
    }
}
