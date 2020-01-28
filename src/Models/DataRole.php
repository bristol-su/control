<?php


namespace BristolSU\ControlDB\Models;


use BristolSU\ControlDB\AdditionalProperties\HasAdditionalProperties;
use BristolSU\ControlDB\Traits\DataRoleTrait;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataRole extends Model implements \BristolSU\ControlDB\Contracts\Models\DataRole
{
    use SoftDeletes, HasAdditionalProperties, DataRoleTrait;
    
    protected $table = 'control_data_role';

    protected $fillable = [
        'role_name', 'email'
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

    public function id(): int
    {
        return $this->id;
    }

    public function setRoleName(?string $roleName): void
    {
        $this->role_name = $roleName;
        $this->save();
    }

    public function roleName(): ?string
    {
        return $this->role_name;
    }
}