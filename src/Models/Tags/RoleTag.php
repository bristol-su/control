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
    use SoftDeletes, RoleTagTrait {
        setName as baseSetName;
        setDescription as baseSetDescription;
        setReference as baseSetReference;
        setTagCategoryId as baseSetTagCategoryId;
    }

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
        $this->baseSetName($name);
        $this->refresh();
    }

    /**
     * Set the description of the Tag
     *
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->baseSetDescription($description);
        $this->refresh();
    }

    /**
     * Set the reference of the tag
     *
     * @param string $reference
     */
    public function setReference(string $reference): void
    {
        $this->baseSetReference($reference);
        $this->refresh();
    }

    /**
     * Set the tag category ID
     *
     * @param int $categoryId
     */
    public function setTagCategoryId($categoryId): void
    {
        $this->baseSetTagCategoryId($categoryId);
        $this->refresh();
    }

}
