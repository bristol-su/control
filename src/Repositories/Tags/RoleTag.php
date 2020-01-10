<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag as RoleTagModelContract;
use BristolSU\ControlDB\Models\Tags\RoleTag as RoleTagModel;
use BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTag as RoleTagContract;
use Illuminate\Support\Collection;

/**
 * Class RoleTag
 * @package BristolSU\ControlDB\Repositories
 */
class RoleTag extends RoleTagContract
{

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return RoleTagModel::all();
    }

    /**
     * @inheritDoc
     */
    public function getTagByFullReference(string $reference): RoleTagModelContract
    {
        $fullTagReference = explode('.', $reference);
        $categoryReference = $fullTagReference[0];
        $tagReference = $fullTagReference[1];

        return RoleTagModel::where('reference', $tagReference)->whereHas('categoryRelationship', function($builder) use ($categoryReference) {
            $builder->where('reference', $categoryReference);
        })->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): RoleTagModelContract
    {
        return RoleTagModel::where('id', $id)->firstOrFail();
    }
}
