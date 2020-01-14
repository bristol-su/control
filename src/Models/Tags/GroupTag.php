<?php


namespace BristolSU\ControlDB\Models\Tags;


use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Scopes\GroupTagScope;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag as GroupTagContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Class GroupTag
 * @package BristolSU\ControlDB\Models
 */
class GroupTag extends Model implements GroupTagContract
{

    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new GroupTagScope());
    }

    protected $table = 'control_tags';

    protected $guarded = [];


    /**
     * ID of the group tag
     *
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * Name of the tag
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Description of the tag
     *
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }

    /**
     * Reference of the tag
     *
     * @return string
     */
    public function reference(): string
    {
        return $this->reference;
    }

    /**
     * ID of the tag category
     * @return int
     */
    public function categoryId(): int
    {
        return $this->tag_category_id;
    }

    /**
     * Tag Category
     *
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory
     */
    public function category(): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory
    {
        return $this->categoryRelationship;
    }

    /**
     * Full reference of the tag
     *
     * This should be the tag category reference and the tag reference, separated with a period.
     * @return string
     */
    public function fullReference(): string
    {
        return $this->category()->reference() . '.' . $this->reference;
    }

    /**
     * Groups who have this tag
     *
     * @return Collection
     */
    public function groups(): Collection
    {
        return $this->groupRelationship;
    }

    public function categoryRelationship()
    {
        return $this->belongsTo(\BristolSU\ControlDB\Models\Tags\GroupTagCategory::class, 'tag_category_id');
    }

    public function groupRelationship()
    {
        return $this->morphedByMany(
            Group::class,
            'taggable',
            'control_taggables',
            'tag_id',
            'taggable_id'
        );
    }

    public function setName(string $name)
    {
        $this->name = $name;
        $this->save();
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
        $this->save();
    }

    public function setReference(string $reference)
    {
        $this->reference = $reference;
        $this->save();
    }

    public function setTagCategoryId($categoryId)
    {
        $this->category_id = $categoryId;
        $this->save();
    }

    public function addGroup(\BristolSU\ControlDB\Contracts\Repositories\Group $group)
    {
        $this->groupRelationship()->attach($group->id());
    }

    public function removeGroup(\BristolSU\ControlDB\Contracts\Repositories\Group $group)
    {
        $this->groupRelationship()->detach($group->id());
    }
}
