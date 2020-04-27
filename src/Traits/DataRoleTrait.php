<?php


namespace BristolSU\ControlDB\Traits;


use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Repositories\DataRole;
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

    /**
     * Set the email of the role
     *
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        app(DataRole::class)->update($this->id(), $this->roleName(), $email);
    }


    /**
     * Set a name for the role
     *
     * @param string|null $roleName
     */
    public function setRoleName(?string $roleName): void
    {
        app(DataRole::class)->update($this->id(), $roleName, $this->email());

    }
}