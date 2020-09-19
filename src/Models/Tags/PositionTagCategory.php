<?php

namespace BristolSU\ControlDB\Models\Tags;

use BristolSU\ControlDB\Scopes\PositionTagCategoryScope;
use BristolSU\ControlDB\Traits\Tags\PositionTagCategoryTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Position Tag Category
 */
class PositionTagCategory extends Model implements \BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory
{
    use SoftDeletes, PositionTagCategoryTrait {
        setName as baseSetName;
        setDescription as baseSetDescription;
        setReference as baseSetReference;
    }

    /**
     * Boot the model
     *
     * - Add a scope to only retrieve position tag categories
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new PositionTagCategoryScope());
        static::creating(function($model) {
            $model->type = 'position';
        });
    }

    /**
     * Table to use
     *
     * @var string
     */
    protected $table = 'control_tag_categories';

    /**
     * Fillable attributes
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'reference'
    ];

    /**
     * ID of the tag category
     *
     * @return mixed
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Name of the tag category
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Deacription of the tag category
     *
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }

    /**
     * Reference of the tag category
     *
     * @return string
     */
    public function reference(): string
    {
        return $this->reference;
    }

    /**
     * Set the name of the tag category
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->baseSetName($name);
        $this->refresh();
    }

    /**
     * Set the description of the tag category
     *
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->baseSetDescription($description);
        $this->refresh();
    }

    /**
     * Set the reference of the tag category
     *
     * @param string $reference
     */
    public function setReference(string $reference): void
    {
        $this->baseSetReference($reference);
        $this->refresh();
    }

}
