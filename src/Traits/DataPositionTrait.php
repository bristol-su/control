<?php


namespace BristolSU\ControlDB\Traits;


use BristolSU\ControlDB\Contracts\Models\Position;
use BristolSU\ControlDB\Contracts\Repositories\DataPosition;
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

    /**
     * Set the position name
     *
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        app(DataPosition::class)->update($this->id(), $name, $this->description());
    }

    /**
     * Set the description
     *
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        app(DataPosition::class)->update($this->id(), $this->name(), $description);

    }
}