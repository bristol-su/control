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
class RoleTag implements RoleTagContract
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

        $tagCategory = app(\BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTagCategory::class)->getByReference($categoryReference);

        return RoleTagModel::where([
            'reference' => $tagReference,
            'tag_category_id' => $tagCategory->id()
        ])->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): RoleTagModelContract
    {
        return RoleTagModel::where('id', $id)->firstOrFail();
    }

    public function create(string $name, string $description, string $reference, $tagCategoryId): \BristolSU\ControlDB\Contracts\Models\Tags\RoleTag
    {
        return \BristolSU\ControlDB\Models\Tags\RoleTag::create([
            'name' => $name,
            'description' => $description,
            'reference' => $reference,
            'tag_category_id' => $tagCategoryId
        ]);
    }

    public function delete(int $id): void
    {
        $this->getById($id)->delete();
    }

    public function allThroughTagCategory(\BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory $roleTagCategory): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\RoleTag::where('tag_category_id', $roleTagCategory->id())->get();
    }
    
}
