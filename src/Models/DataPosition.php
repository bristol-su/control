<?php


namespace BristolSU\ControlDB\Models;


use DateTime;
use Illuminate\Database\Eloquent\Model;

class DataPosition extends Model implements \BristolSU\ControlDB\Contracts\Models\DataPosition
{

    protected $table = 'control_data_position';
    
    protected $fillable = [
        'name', 'description'
    ];
    
    public function setName(?string $name): void
    {
        $this->name = $name;
        $this->save();
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
        $this->save();
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function id()
    {
        return $this->id;
    }
}