<?php


namespace BristolSU\ControlDB\Models;


use BristolSU\Support\Control\Contracts\Models\Position as PositionContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Position
 * @package BristolSU\ControlDB\Models
 */
class Position extends Model implements PositionContract
{
    
    protected $table = 'control_position';
    
    /**
     * Name of the position
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name;
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

    protected function roleRelationship()
    {
        return $this->hasMany(Role::class);
    }

    protected function tagRelationship()
    {
        
    }
}
