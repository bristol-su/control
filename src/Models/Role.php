<?php


namespace BristolSU\ControlDB\Models;


use BristolSU\ControlDB\Traits\RoleTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Role
 * @package BristolSU\ControlDB\Models
 */
class Role extends Model implements \BristolSU\ControlDB\Contracts\Models\Role
{

    use SoftDeletes, RoleTrait;

    protected $table = 'control_roles';

    protected $fillable = [ 
        'position_id', 'group_id', 'data_provider_id'
    ];

    protected $appends = [
        'data'
    ];

    public function getDataAttribute()
    {
        return $this->data();
    }

    public function dataProviderId(): int
    {
        return $this->data_provider_id;
    }
    
    /**
     * Get the ID of the role
     *
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * ID of the position
     *
     * @return mixed
     */
    public function positionId(): int
    {
        return $this->position_id;
    }

    /**
     * ID of the group
     *
     * @return mixed
     */
    public function groupId(): int
    {
        return $this->group_id;
    }

   

    public function setGroupId(int $groupId): void
    {
        $this->group_id = $groupId;
        $this->save();    
    }

    public function setPositionId(int $positionId): void
    {
        $this->position_id = $positionId;
        $this->save();    
    }

    public function setDataProviderId(int $dataProviderId): void
    {
        $this->data_provider_id = $dataProviderId;
        $this->save();
    }
}
