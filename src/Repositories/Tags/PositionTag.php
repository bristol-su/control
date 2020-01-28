<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag as PositionTagModelContract;
use BristolSU\ControlDB\Models\Tags\PositionTag as PositionTagModel;
use BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTag as PositionTagContract;
use Illuminate\Support\Collection;

/**
 * Class PositionTag
 */
class PositionTag implements PositionTagContract
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

        $tagCategory = app(\BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTagCategory::class)->getByReference($categoryReference);

        return PositionTagModel::where([
            'reference' => $tagReference,
            'tag_category_id' => $tagCategory->id()
        ])->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): PositionTagModelContract
    {
        return PositionTagModel::where('id', $id)->firstOrFail();
    }

    public function create(string $name, string $description, string $reference, $tagCategoryId): \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag
    {
        return \BristolSU\ControlDB\Models\Tags\PositionTag::create([
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

    public function allThroughTagCategory(\BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory $positionTagCategory): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\PositionTag::where('tag_category_id', $positionTagCategory->id())->get();
    }
}
