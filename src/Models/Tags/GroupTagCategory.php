<?php

namespace BristolSU\ControlDB\Models\Tags;

use BristolSU\ControlDB\Scopes\GroupTagCategoryScope;
use BristolSU\Support\Control\Contracts\Models\Tags\GroupTagCategory as GroupTagCategoryContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class GroupTag
 * @package BristolSU\ControlDB\Models
 */
class GroupTagCategory extends Model implements GroupTagCategoryContract
{
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new GroupTagCategoryScope());
    }

    protected $table = 'control_tag_category';
    
    /**
     * ID of the tag category
     *
     * @return mixed
     */
    public function id()
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
     * All tags under this tag category
     *
     * @return Collection
     */
    public function tags(): Collection
    {
        return $this->tagRelationship;
    }

    protected function tagRelationship()
    {
        return $this->hasMany(GroupTag::class);
    }
}
