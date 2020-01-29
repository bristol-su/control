<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\ControlDB\Models\Tags\UserTag as UserTagModel;
use BristolSU\ControlDB\Contracts\Repositories\Tags\UserTag as UserTagContract;
use Illuminate\Support\Collection;

/**
 * Class UserTag
 * @package BristolSU\ControlDB\Repositories
 */
class UserTag implements UserTagContract
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

        $tagCategory = app(\BristolSU\ControlDB\Contracts\Repositories\Tags\UserTagCategory::class)->getByReference($categoryReference);

        return UserTagModel::where([
            'reference' => $tagReference,
            'tag_category_id' => $tagCategory->id()
        ])->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\Tags\UserTag
    {
        return UserTagModel::where('id', $id)->firstOrFail();
    }

    public function create(string $name, string $description, string $reference, int $tagCategoryId): \BristolSU\ControlDB\Contracts\Models\Tags\UserTag
    {
        return \BristolSU\ControlDB\Models\Tags\UserTag::create([
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

    public function allThroughTagCategory(\BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory $userTagCategory): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\UserTag::where('tag_category_id', $userTagCategory->id())->get();
    }
}
