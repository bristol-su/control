<?php


namespace BristolSU\ControlDB\Models;


use BristolSU\ControlDB\Traits\PositionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Position
 * @package BristolSU\ControlDB\Models
 */
class Position extends Model implements \BristolSU\ControlDB\Contracts\Models\Position
{
    use SoftDeletes, PositionTrait;

    protected $table = 'control_positions';

    protected $fillable = [ 'data_provider_id' ];

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
     * ID of the position
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
