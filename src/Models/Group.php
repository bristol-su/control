<?php

namespace BristolSU\ControlDB\Models;

use BristolSU\ControlDB\Traits\GroupTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Group
 * @package BristolSU\ControlDB\Models
 */
class Group extends Model implements \BristolSU\ControlDB\Contracts\Models\Group
{
    use SoftDeletes, GroupTrait;

    protected $table = 'control_groups';

    protected $fillable = ['data_provider_id'];

    protected $appends = [
        'data'
    ];

    public function getDataAttribute(): \BristolSU\ControlDB\Contracts\Models\DataGroup
    {
        return $this->data();
    }

    public function dataProviderId(): int
    {
        return $this->data_provider_id;
    }

    /**
     * ID of the group
     *
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    

    public function setDataProviderId(int $dataProviderId): void
    {
        $this->data_provider_id = $dataProviderId;
        $this->save();
    }
}
