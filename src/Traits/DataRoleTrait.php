<?php


namespace BristolSU\ControlDB\Traits;


use BristolSU\ControlDB\Contracts\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Implements methods to the data role interface using repositories
 */
trait DataRoleTrait
{

    /**
     * Get the role using the data role
     *
     * @return Role|null
     */
    public function role(): ?Role
    {
        try {
            return app(\BristolSU\ControlDB\Contracts\Repositories\Role::class)->getByDataProviderId($this->id());
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }
}