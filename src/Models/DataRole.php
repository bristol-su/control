<?php


namespace BristolSU\ControlDB\Models;


use DateTime;
use Illuminate\Database\Eloquent\Model;

class DataRole extends Model implements \BristolSU\ControlDB\Contracts\Models\DataRole
{

    protected $table = 'control_data_role';

    protected $fillable = [
        'position_name', 'email'
    ];

    public function setEmail(?string $email): void
    {
        $this->email = $email;
        $this->save();
    }

    public function email(): ?string
    {
        return $this->email;
    }

    public function id()
    {
        return $this->id;
    }

    public function setPositionName(?string $positionName): void
    {
        $this->position_name = $positionName;
        $this->save();
    }

    public function positionName(): ?string
    {
        return $this->position_name;
    }
}