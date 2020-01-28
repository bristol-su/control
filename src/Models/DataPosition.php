<?php


namespace BristolSU\ControlDB\Models;


use BristolSU\ControlDB\AdditionalProperties\HasAdditionalProperties;
use BristolSU\ControlDB\Traits\DataPositionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Handles attributes belonging to a position
 */
class DataPosition extends Model implements \BristolSU\ControlDB\Contracts\Models\DataPosition
{
    use SoftDeletes, HasAdditionalProperties, DataPositionTrait;

    /**
     * Sets table to use
     * 
     * @var string 
     */
    protected $table = 'control_data_position';

    /**
     * Sets the fillable attributes
     * 
     * @var array 
     */
    protected $fillable = [
        'name', 'description'
    ];

    /**
     * Gets the ID of the position
     *
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * Sets the name of the position
     * 
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
        $this->save();
    }

    /**
     * Sets the description of the position
     * 
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
        $this->save();
    }

    /**
     * Gets the name of the position
     * 
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->name;
    }

    /**
     * Gets the description of the position
     * 
     * @return string|null
     */
    public function description(): ?string
    {
        return $this->description;
    }
}