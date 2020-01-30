<?php

namespace BristolSU\ControlDB\Models\Tags;

use BristolSU\ControlDB\Scopes\GroupTagCategoryScope;
use BristolSU\ControlDB\Traits\Tags\GroupTagCategoryTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Group Tag Category
 */
class GroupTagCategory extends Model implements \BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory
{
    use SoftDeletes, GroupTagCategoryTrait;

    /**
     * Boot the model
     * 
     * - Add a scope to only retrieve group tag categories
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new GroupTagCategoryScope());
        static::creating(function($model) {
            $model->type = 'group';
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
        $this->name = $name;
        $this->save();
    }

    /**
     * Set the description of the tag category
     * 
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
        $this->save();
    }

    /**
     * Set the reference of the tag category
     * 
     * @param string $reference
     */
    public function setReference(string $reference): void
    {
        $this->reference = $reference;
        $this->save();
    }
}
