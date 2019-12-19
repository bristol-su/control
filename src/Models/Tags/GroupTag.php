<?php


namespace BristolSU\ControlDB\Models\Tags;


use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Scopes\GroupTagScope;
use BristolSU\Support\Control\Contracts\Models\Tags\GroupTag as GroupTagContract;
use BristolSU\Support\Control\Contracts\Models\Tags\GroupTagCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class GroupTag
 * @package BristolSU\ControlDB\Models
 */
class GroupTag extends GroupTagContract
{
    
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
     * @return GroupTagCategory
     */
    public function category(): GroupTagCategory
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
            'taggable_id',
            'tag_id'
        );
    }
}
