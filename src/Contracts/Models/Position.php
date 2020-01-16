<?php


namespace BristolSU\ControlDB\Contracts\Models;


use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag;
use Illuminate\Support\Collection;

/**
 * Interface Position
 * @package BristolSU\ControlDB\Contracts\Models
 */
interface Position
{

    // TODO Abstract!
    public function data(): DataPosition;

    public function dataProviderId();
    
    /**
     * ID of the position
     *
     * @return int
     */
    public function id(): int;

    /**
     * Roles with this position
     *
     * @return Collection
     */
    // TODO Abstract!
    public function roles(): Collection;

    /**
     * Tags the position is tagged with
     *
     * @return Collection
     */
    // TODO Abstract!
    public function tags(): Collection;

    public function setDataProviderId(int $dataProviderId);

    // TODO Abstract!
    public function addTag(PositionTag $roleTag);

    // TODO Abstract!
    public function removeTag(PositionTag $roleTag);


}
