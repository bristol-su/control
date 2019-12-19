<?php


namespace BristolSU\ControlDB\Contracts\Models;


use Illuminate\Support\Collection;

/**
 * Interface Position
 * @package BristolSU\ControlDB\Contracts\Models
 */
abstract class Position
{

    /**
     * Name of the position
     * 
     * @return string
     */
    public function name(): string;

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
    public function roles(): Collection;

    /**
     * Tags the position is tagged with
     *
     * @return Collection
     */
    public function tags(): Collection;
    
}
