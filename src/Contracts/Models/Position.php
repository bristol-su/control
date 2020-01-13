<?php


namespace BristolSU\ControlDB\Contracts\Models;


use Illuminate\Support\Collection;

/**
 * Interface Position
 * @package BristolSU\ControlDB\Contracts\Models
 */
interface Position
{

    /**
     * Name of the position
     *
     * @return string
     */
    public function name(): string;

    // TODO Abstract!
    public function data(): DataPosition;

    public function dataProviderId();
    
    /**
     * Description of the position
     *
     * @return string
     */
    public function description(): string;

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


}
