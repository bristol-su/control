<?php

namespace BristolSU\ControlDB\Models\Tags;

use BristolSU\ControlDB\Scopes\RoleTagScope;
use BristolSU\ControlDB\Traits\Tags\RoleTagTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RoleTag
 */
class RoleTag extends Model implements \BristolSU\ControlDB\Contracts\Models\Tags\RoleTag
{
    use SoftDeletes, RoleTagTrait;

    /**
     * Boot the model
     *
     * - Add a global scope to only return role tags
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new RoleTagScope());
    }

    /**
     * Table to use
     *
     * @var string
     */
    protected $table = 'control_tags';

    /**
     * Fillable properties
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'reference', 'tag_category_id'
    ];

    /**
     * Append the full reference
     *
     * @var array Attributes to append
     */
    protected $appends = [
        'full_reference'
    ];

    public function getFullReferenceAttribute()
    {
        return $this->fullReference();
    }
    
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
     *
     * @return int
     */
    public function categoryId(): int
    {
        return $this->tag_category_id;
    }

    /**
     * Set the name of the tag
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
        $this->save();
    }

    /**
     * Set the description of the tagTag Reference
     *
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
        $this->save();
    }

    /**
     * Set the reference of the tag
     *
     * @param string $reference
     */
    public function setReference(string $reference): void
    {
        $this->reference = $reference;
        $this->save();
    }

    /**
     * Set the tag category ID
     *
     * @param int $categoryId
     */
    public function setTagCategoryId($categoryId): void
    {
        $this->tag_category_id = $categoryId;
        $this->save();
    }

}
