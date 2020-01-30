<?php


namespace BristolSU\ControlDB\Traits;


use BristolSU\ControlDB\Contracts\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Implements methods to the data user interface using repositories
 */
trait DataUserTrait
{

    /**
     * Get the user using the data user
     *
     * @return User|null
     */
    public function user(): ?User
    {
        try {
            return app(\BristolSU\ControlDB\Contracts\Repositories\User::class)->getByDataProviderId($this->id());
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }
}