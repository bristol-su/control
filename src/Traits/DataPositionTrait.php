<?php


namespace BristolSU\ControlDB\Traits;


use BristolSU\ControlDB\Contracts\Models\Position;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait DataPositionTrait
{

    /**
     * Get the position with these attributes
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