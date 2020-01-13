<?php


namespace BristolSU\ControlDB\Models;


use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\ControlDB\Models\Tags\PositionTag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Class Position
 * @package BristolSU\ControlDB\Models
 */
class Position extends Model implements \BristolSU\ControlDB\Contracts\Models\Position
{
    use SoftDeletes;

    protected $table = 'control_positions';

    protected $guarded = [];

    protected $appends = [
        'data'
    ];

    public function getDataAttribute()
    {
        return $this->data();
    }
    
    /**
     * Name of the position
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    public function data(): \BristolSU\ControlDB\Contracts\Models\DataPosition {
        return app(\BristolSU\ControlDB\Contracts\Repositories\DataPosition::class)->getById($this->dataProviderId());
    }

    public function dataProviderId()
    {
        return $this->data_provider_id;
    }
    
    /**
     * Description of the position
     *
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }

    /**
     * ID of the position
     *
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * Roles with this position
     *
     * @return Collection
     */
    public function roles(): Collection
    {
        return $this->roleRelationship;
    }

    /**
     * Tags the position is tagged with
     *
     * @return Collection
     */
    public function tags(): Collection
    {
        return $this->tagRelationship;
    }

    public function roleRelationship()
    {
        return $this->hasMany(Role::class);
    }

    public function tagRelationship()
    {
        return $this->morphToMany(PositionTag::class,
            'taggable',
            'control_taggables',
            'taggable_id',
            'tag_id');
    }
}
