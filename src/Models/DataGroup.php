<?php

namespace BristolSU\ControlDB\Models;

use BristolSU\ControlDB\AdditionalProperties\HasAdditionalProperties;
use BristolSU\ControlDB\Traits\DataGroupTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataGroup extends Model implements \BristolSU\ControlDB\Contracts\Models\DataGroup
{
    use SoftDeletes, HasAdditionalProperties, DataGroupTrait;

    protected $table = 'control_data_group';
    
    protected $fillable = [
        'name', 'email'
    ];
    
    public function setName(?string $name): void
    {
        $this->name = $name;
        $this->save();
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
        $this->save();
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function email(): ?string
    {
        return $this->email;
    }

    public function id(): int
    {
        return $this->id;
    }
    
}