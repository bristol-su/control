<?php

namespace BristolSU\ControlDB\Observers\NotifyObservers\Framework;

use Illuminate\Support\Facades\Facade;

/**
 * @method static attach(string $notifier, string $observer) Observe the given repository contract with the given observer
 */
class Observe extends Facade
{

    protected static function getFacadeAccessor()
    {
        return ObserverStore::class;
    }

}