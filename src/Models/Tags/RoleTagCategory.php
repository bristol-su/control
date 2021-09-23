<?php

namespace BristolSU\ControlDB\Models\Tags;

use BristolSU\ControlDB\Scopes\RoleTagCategoryScope;
use BristolSU\ControlDB\Traits\Tags\RoleTagCategoryTrait;
use Database\Factories\RoleTagCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Role Tag Category
 */
class RoleTagCategory extends Model implements \BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory
{
    use SoftDeletes, HasFactory, RoleTagCategoryTrait {
        setName as baseSetName;
        setDescription as baseSetDescription;
        setReference as baseSetReference;
    }

    /**
     * Boot the model
     *
     * - Add a scope to only retrieve role tag categories
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new RoleTagCategoryScope());
        static::creating(function($model) {
            $model->type = 'role';
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
     * ID of the tag category
     *
     * @return mixed
     */
    public function id(): int
    {
        return $this->id;
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

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return new RoleTagCategoryFactory();
    }

}
