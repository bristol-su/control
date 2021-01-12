<?php

namespace BristolSU\ControlDB\Models;

use BristolSU\ControlDB\Traits\GroupTrait;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Represents a group
 */
class Group extends Model implements \BristolSU\ControlDB\Contracts\Models\Group
{
    use SoftDeletes, GroupTrait {
        setDataProviderId as baseSetDataProviderId;
    }

    /**
     * Table to use
     *
     * @var string
     */
    protected $table = 'control_groups';

    /**
     * Fillable attributes
     *
     * @var array
     */
    protected $fillable = ['data_provider_id'];

    /**
     * Attributes to append when casting to an array
     *
     * @var array
     */
    protected $appends = [
        'data'
    ];

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
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

    /**
     * ID of the data provider for the group
     *
     * @return int
     */
    public function dataProviderId(): int
    {
        return $this->data_provider_id;
    }

    /**
     * Laravel integration for a data property
     *
     * @return \BristolSU\ControlDB\Contracts\Models\DataGroup
     */
    public function getDataAttribute(): \BristolSU\ControlDB\Contracts\Models\DataGroup
    {
        return $this->data();
    }

    /**
     * Set the ID of the data provider
     *
     * @param int $dataProviderId
     */
    public function setDataProviderId(int $dataProviderId): void
    {
        $this->baseSetDataProviderId($dataProviderId);
        $this->refresh();
    }


}
