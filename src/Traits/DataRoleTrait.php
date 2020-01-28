<?php


namespace BristolSU\ControlDB\Traits;


use BristolSU\ControlDB\Contracts\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait DataRoleTrait
{

    public function role(): ?Role
    {
        try {
            return app(\BristolSU\ControlDB\Contracts\Repositories\Role::class)->getByDataProviderId($this->id());
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }
}