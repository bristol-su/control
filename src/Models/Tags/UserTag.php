<?php


namespace BristolSU\ControlDB\Models\Tags;


use BristolSU\ControlDB\Models\User;
use BristolSU\ControlDB\Scopes\UserTagScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Class UserTag
 * @package BristolSU\ControlDB\Models
 */
class UserTag extends Model implements \BristolSU\ControlDB\Contracts\Models\Tags\UserTag
{

    use SoftDeletes;

    protected $table = 'control_tags';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new UserTagScope());
    }

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
     * Tag Category
     *
     * @return UserTagCategory
     */
    public function category(): \BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory
    {
        return $this->categoryRelationship;
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
        return $this->belongsTo(UserTagCategory::class, 'tag_category_id');
    }

    public function userRelationship()
    {
        return $this->morphedByMany(User::class, 'taggable', 'control_taggables', 'tag_id',
            'taggable_id');
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

    public function addUser(\BristolSU\ControlDB\Contracts\Models\User $user)
    {
        $this->userRelationship()->attach($user->id());
    }

    public function removeUser(\BristolSU\ControlDB\Contracts\Models\User $user)
    {
        $this->userRelationship()->detach($user->id());
    }
}
