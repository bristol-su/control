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
    use SoftDeletes, HasAdditionalProperties, DataPositionTrait {
        setName as baseSetName;
        setDescription as baseSetDescription;
    }

    /**
     * Defines the table
     * 
     * @var string 
     */
    protected $table = 'control_data_position';

    /**
     * Defines the fillable properties
     * 
     * @var array 
     */
    protected $fillable = [
        'name', 'description'
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
     * Name of the position
     * 
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->name;
    }

    /**
     * Description for the position.
     * 
     * @return string|null
     */
    public function description(): ?string
    {
        return $this->description;
    }

    /**
     * Set the position name
     *
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->baseSetName($name);
        $this->refresh();
    }

    /**
     * Set the description
     *
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->baseSetDescription($description);
        $this->refresh();
    }


}