<?php

namespace BristolSU\ControlDB\Observers\NotifyObservers\Framework;

class ObserverStore
{

    private $observers = [];
    
    public function attach($notifier, $observer): void
    {
        if(!array_key_exists($notifier, $this->observers)) {
            $this->observers[$notifier] = [];
        }
        $this->observers[$notifier][] = $observer;
    }

    public function detach($notifier, $observer): void
    {
        if (array_key_exists($notifier, $this->observers)) {
            if (array_key_exists($observer, $this->observers[$notifier])) {
                unset($this->observers[$notifier][$observer]);
            }
        }
    }
    
    public function forNotifier($notifier): array
    {
        if(array_key_exists($notifier, $this->observers)) {
            return $this->observers[$notifier];
        }
        return [];
    }
}