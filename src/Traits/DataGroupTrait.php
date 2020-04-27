<?php


namespace BristolSU\ControlDB\Traits;


use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Repositories\DataGroup;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Implements methods to the data group interface using repositories
 */
trait DataGroupTrait
{

    /**
     * Get the group using the data group
     *
     * @return Group|null
     */
    public function group(): ?Group
    {
        try {
            return app(\BristolSU\ControlDB\Contracts\Repositories\Group::class)->getByDataProviderId($this->id());
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    /**
     * Set the name of the group
     *
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        app(DataGroup::class)->update($this->id(), $name, $this->email());
    }

    /**
     * Set the email of the group
     *
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        app(DataGroup::class)->update($this->id(), $this->name(), $email);
    }
}