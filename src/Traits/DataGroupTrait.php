<?php


namespace BristolSU\ControlDB\Traits;


use BristolSU\ControlDB\Contracts\Models\Group;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Implements methods to the data group interface using repositories
 */
trait DataGroupTrait
{

    /**
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
}