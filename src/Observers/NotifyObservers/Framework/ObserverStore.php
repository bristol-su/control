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
            if (($key = array_search($observer, $this->observers[$notifier])) !== false) {
                unset($this->observers[$notifier][$key]);
                $this->observers[$notifier] = array_values($this->observers[$notifier]);
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