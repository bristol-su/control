<?php


namespace BristolSU\ControlDB\Models\Tags;


use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Scopes\RoleTagScope;
use BristolSU\Support\Control\Contracts\Models\Tags\RoleTagCategory;
use BristolSU\Support\Control\Contracts\Models\Tags\RoleTag as RoleTagContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class RoleTag
 * @package BristolSU\ControlDB\Models
 */
class RoleTag extends Model implements RoleTagContract
{
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new RoleTagScope());
    }

    protected $table = 'control_tags';

    protected $guarded = [];


    /**
     * ID of the role tag
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
     * @return RoleTagCategory
     */
    public function category(): RoleTagCategory
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
     * Roles who have this tag
     *
     * @return Collection
     */
    public function roles(): Collection
    {
        return $this->roleRelationship;
    }

    public function categoryRelationship()
    {
        return $this->belongsTo(\BristolSU\ControlDB\Models\Tags\RoleTagCategory::class, 'tag_category_id');
    }

    public function roleRelationship()
    {
        return $this->morphedByMany(Role::class, 'taggable', 'control_taggables', 'taggable_id', 'tag_id');
    }
}
