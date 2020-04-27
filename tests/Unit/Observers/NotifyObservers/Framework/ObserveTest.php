<?php

namespace BristolSU\Tests\ControlDB\Unit\Observers\NotifyObservers\Framework;

use BristolSU\ControlDB\Observers\NotifyObservers\Framework\Observe;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\ObserverStore;
use BristolSU\Tests\ControlDB\TestCase;

class ObserveTest extends TestCase
{

    /** @test */
    public function it_calls_the_underlying_instance(){
        $observerStore = $this->prophesize(ObserverStore::class);
        $observerStore->attach('one', 'two')->shouldBeCalled();
        $this->instance(ObserverStore::class, $observerStore->reveal());
        
        Observe::clearResolvedInstances();
        Observe::attach('one', 'two');
    }
    
}