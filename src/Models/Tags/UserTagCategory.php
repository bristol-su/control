<?php

namespace BristolSU\ControlDB\Models\Tags;

use BristolSU\ControlDB\Scopes\UserTagCategoryScope;
use BristolSU\ControlDB\Traits\Tags\UserTagCategoryTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Class UserTag
 * @package BristolSU\ControlDB\Models
 */
class UserTagCategory extends Model implements \BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory
{
    use SoftDeletes, UserTagCategoryTrait;

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new UserTagCategoryScope());
        static::creating(function($model) {
            $model->type = 'user';
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
