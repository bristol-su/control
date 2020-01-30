<?php


namespace BristolSU\ControlDB\Models;


use BristolSU\ControlDB\Traits\PositionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Represents a position
 */
class Position extends Model implements \BristolSU\ControlDB\Contracts\Models\Position
{
    use SoftDeletes, PositionTrait;

    /**
     * Table to use
     *
     * @var string
     */
    protected $table = 'control_positions';

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
     * ID of the position
     *
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * ID of the data provider for the position
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
     * @return \BristolSU\ControlDB\Contracts\Models\DataPosition
     */
    public function getDataAttribute(): \BristolSU\ControlDB\Contracts\Models\DataPosition
    {
        return $this->data();
    }

}
