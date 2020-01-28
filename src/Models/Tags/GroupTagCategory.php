<?php

namespace BristolSU\ControlDB\Models\Tags;

use BristolSU\ControlDB\Scopes\GroupTagCategoryScope;
use BristolSU\ControlDB\Traits\Tags\GroupTagCategoryTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Class GroupTag
 * @package BristolSU\ControlDB\Models
 */
class GroupTagCategory extends Model implements \BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory
{
    use SoftDeletes, GroupTagCategoryTrait;

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new GroupTagCategoryScope());
        static::creating(function($model) {
            $model->type = 'group';
        });
    }

    protected $table = 'control_tag_categories';
    
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
}
