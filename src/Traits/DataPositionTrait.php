<?php


namespace BristolSU\ControlDB\Traits;


use BristolSU\ControlDB\Contracts\Models\Position;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Implements methods to the data position interface using repositories
 */
trait DataPositionTrait
{

    /**
     * Get the position using the data position
     *
     * @return Position|null
     */
    public function position(): ?Position
    {
        try {
            return app(\BristolSU\ControlDB\Contracts\Repositories\Position::class)->getByDataProviderId($this->id());
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }
}