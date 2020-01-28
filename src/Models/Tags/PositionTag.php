<?php

namespace BristolSU\ControlDB\Models\Tags;

use BristolSU\ControlDB\Scopes\PositionTagScope;
use BristolSU\ControlDB\Traits\Tags\PositionTagTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PositionTag
 * @package BristolSU\ControlDB\Models
 */
class PositionTag extends Model implements \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag
{
    use SoftDeletes, PositionTagTrait;

    protected $table = 'control_tags';

    protected $fillable = [
        'name', 'description', 'reference', 'tag_category_id'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new PositionTagScope());
    }

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

    public function setName(string $name): void
    {
        $this->name = $name;
        $this->save();
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
        $this->save();
    }

    public function setReference(string $reference): void
    {
        $this->reference = $reference;
        $this->save();
    }

    public function setTagCategoryId($categoryId): void
    {
        $this->category_id = $categoryId;
        $this->save();
    }
    
}
