<?php


namespace BristolSU\ControlDB\Models\Tags;


use BristolSU\ControlDB\Models\User;
use BristolSU\ControlDB\Scopes\UserTagScope;
use BristolSU\Support\Control\Contracts\Models\Tags\UserTagCategory;
use BristolSU\Support\Control\Contracts\Models\Tags\UserTag as UserTagContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class UserTag
 * @package BristolSU\ControlDB\Models
 */
class UserTag extends Model implements UserTagContract
{
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new UserTagScope());
    }

    protected $table = 'control_tags';

    protected $guarded = [];


    /**
     * ID of the user tag
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
     * @return UserTagCategory
     */
    public function category(): UserTagCategory
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
        return $this->reference . '.' . $this->category()->reference();
    }

    /**
     * Users who have this tag
     *
     * @return Collection
     */
    public function users(): Collection
    {
        return $this->userRelationship;
    }

    public function categoryRelationship()
    {
        return $this->belongsTo(\BristolSU\ControlDB\Models\Tags\UserTagCategory::class, 'tag_category_id');
    }

    public function userRelationship()
    {
        return $this->morphedByMany(User::class, 'taggable', 'control_taggables', 'taggable_id', 'tag_id');
    }
}
