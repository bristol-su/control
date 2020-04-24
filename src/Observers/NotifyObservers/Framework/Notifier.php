<?php

namespace BristolSU\ControlDB\Observers\NotifyObservers\Framework;

class Notifier
{

    /**
     * @var ObserverStore
     */
    private $observerStore;
    /**
     * @var string
     */
    private $notifier;

    public function __construct(ObserverStore $observerStore, string $notifier)
    {
        $this->observerStore = $observerStore;
        $this->notifier = $notifier;
    }

    public function attach($observer)
    {
        $this->observerStore->attach($this->notifier, $observer);
    }

    public function detach($observer)
    {
        $this->observerStore->detach($this->notifier, $observer);
    }

    public function notify($method, ...$params)
    {
        foreach($this->observerStore->forNotifier($this->notifier) as $notifierClass)  {
            $notifier = app($notifierClass);
            if(method_exists($notifier, $method)) {
                $notifier->{$method}(...$params);
            }
        }
    }
    
}