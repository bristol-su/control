<?php


namespace BristolSU\ControlDB\Models\Tags;


use BristolSU\ControlDB\Models\Position;
use BristolSU\ControlDB\Scopes\PositionTagScope;
use BristolSU\Support\Control\Contracts\Models\Tags\PositionTag as PositionTagModel;
use BristolSU\Support\Control\Contracts\Models\Tags\PositionTagCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class PositionTag
 * @package BristolSU\ControlDB\Models
 */
class PositionTag extends Model implements PositionTagModel
{
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new PositionTagScope());
    }

    protected $table = 'control_tags';

    protected $guarded = [];


    /**
     * ID of the position tag
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
     * @return PositionTagCategory
     */
    public function category(): PositionTagCategory
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
     * Positions who have this tag
     *
     * @return Collection
     */
    public function positions(): Collection
    {
        return $this->positionRelationship;
    }

    public function categoryRelationship()
    {
        return $this->belongsTo(\BristolSU\ControlDB\Models\Tags\PositionTagCategory::class, 'tag_category_id');
    }

    public function positionRelationship()
    {
        return $this->morphedByMany(Position::class, 'taggable', 'control_taggables', 'taggable_id', 'tag_id');
    }
}
