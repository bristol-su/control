<?php


namespace BristolSU\ControlDB\Models;


use BristolSU\ControlDB\Traits\RoleTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Represents a role
 */
class Role extends Model implements \BristolSU\ControlDB\Contracts\Models\Role
{

    use SoftDeletes, RoleTrait;

    /**
     * Table to use
     *
     * @var string
     */
    protected $table = 'control_roles';

    /**
     * Fillable attributes
     *
     * @var array
     */
    protected $fillable = ['data_provider_id', 'group_id', 'position_id'];

    /**
     * Attributes to append when casting to an array
     *
     * @var array
     */
    protected $appends = [
        'data'
    ];

    /**
     * ID of the role
     *
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * ID of the data provider for the role
     *
     * @return int
     */
    public function dataProviderId(): int
    {
        return $this->data_provider_id;
    }

    /**
     * Set the ID of the data provider
     *
     * @param int $dataProviderId
     */
    public function setDataProviderId(int $dataProviderId): void
    {
        $this->data_provider_id = $dataProviderId;
        $this->save();
    }

    /**
     * Laravel integration for a data property
     *
     * @return \BristolSU\ControlDB\Contracts\Models\DataRole
     */
    public function getDataAttribute(): \BristolSU\ControlDB\Contracts\Models\DataRole
    {
        return $this->data();
    }

    /**
     * ID of the position the role has
     *
     * @return mixed
     */
    public function positionId(): int
    {
        return $this->position_id;
    }

    /**
     * ID of the group the role belongs to
     *
     * @return mixed
     */
    public function groupId(): int
    {
        return $this->group_id;
    }

    /**
     * Set a group ID
     * 
     * @param int $groupId
     */
    public function setGroupId(int $groupId): void
    {
        $this->group_id = $groupId;
        $this->save();    
    }

    /**
     * Set a position ID
     * 
     * @param int $positionId
     */
    public function setPositionId(int $positionId): void
    {
        $this->position_id = $positionId;
        $this->save();    
    }
}
