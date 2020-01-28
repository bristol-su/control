<?php

namespace BristolSU\ControlDB\Models\Tags;

use BristolSU\ControlDB\Scopes\PositionTagCategoryScope;
use BristolSU\ControlDB\Traits\Tags\PositionTagCategoryTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PositionTag
 * @package BristolSU\ControlDB\Models
 */
class PositionTagCategory extends Model implements \BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory
{

    use SoftDeletes, PositionTagCategoryTrait;

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new PositionTagCategoryScope());
        static::creating(function($model) {
            $model->type = 'position';
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
