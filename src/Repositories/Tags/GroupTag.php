<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTag as GroupTagContract;
use BristolSU\ControlDB\Models\Tags\GroupTag as GroupTagModel;
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
        return GroupTagModel::all();
    }

    /**
     * @inheritDoc
     */
    public function getTagByFullReference(string $reference): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
    {
        $fullTagReference = explode('.', $reference);
        $categoryReference = $fullTagReference[0];
        $tagReference = $fullTagReference[1];
        
        return GroupTagModel::where('reference', $tagReference)->whereHas('categoryRelationship', function($builder) use ($categoryReference) {
            $builder->where('reference', $categoryReference);
        })->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
    {
        return GroupTagModel::where('id', $id)->firstOrFail();
    }

    public function create(string $name, string $description, string $reference, $tagCategoryId): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
    {
        return \BristolSU\ControlDB\Models\Tags\GroupTag::create([
            'name' => $name,
            'description' => $description,
            'reference' => $reference,
            'tag_category_id' => $tagCategoryId
        ]);
    }

    public function delete(int $id)
    {
        $this->getById($id)->delete();
    }
}
