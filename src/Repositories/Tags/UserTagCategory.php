<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\UserTag as UserTagModel;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory as UserTagCategoryModel;
use BristolSU\ControlDB\Contracts\Repositories\Tags\UserTagCategory as UserTagCategoryContract;
use Illuminate\Support\Collection;

/**
 * Class UserTag
 */
class UserTagCategory implements UserTagCategoryContract
{

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\UserTagCategory::all();
    }

    /**
     * @inheritDoc
     */
    public function getByReference(string $reference): UserTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\UserTagCategory::where('reference', $reference)->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): UserTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\UserTagCategory::where('id', $id)->firstOrFail();
    }

    public function create(string $name, string $description, string $reference): UserTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\UserTagCategory::create([
            'name' => $name,
            'description' => $description,
            'reference' => $reference,
        ]);
    }

    public function delete(int $id): void
    {
        $this->getById($id)->delete();
    }
}
