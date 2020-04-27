<?php

namespace BristolSU\Tests\ControlDB\Unit\Observers\NotifyObservers\Framework;

use BristolSU\ControlDB\Observers\NotifyObservers\Framework\Notifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\ObserverStore;
use BristolSU\Tests\ControlDB\TestCase;
use PHPUnit\Framework\Assert;

class NotifierTest extends TestCase
{

    /** @test */
    public function attach_attaches_to_the_underlying_store(){
        $store = $this->prophesize(ObserverStore::class);
        $store->attach('Notifier1', 'Observer1')->shouldBeCalled();
        $store->attach('Notifier1', 'Observer2')->shouldBeCalled();
        
        $notifier = new Notifier($store->reveal(), 'Notifier1');

        $notifier->attach('Observer1');
        $notifier->attach('Observer2');
    }

    /** @test */
    public function detach_detaches_from_the_underlying_store(){
        $store = $this->prophesize(ObserverStore::class);
        $store->detach('Notifier1', 'Observer1')->shouldBeCalled();
        $store->detach('Notifier1', 'Observer2')->shouldBeCalled();

        $notifier = new Notifier($store->reveal(), 'Notifier1');

        $notifier->detach('Observer1');
        $notifier->detach('Observer2');
    }
    
    /** @test */
    public function notify_calls_the_correct_function_if_exists_on_each_observer(){
        $store = $this->prophesize(ObserverStore::class);
        $store->forNotifier('Notifier1')->shouldBeCalled()->willReturn([
            Obs1::class, Obs2::class
        ]);

        $notifier = new Notifier($store->reveal(), 'Notifier1');
        
        $notifier->notify('testMethod', 'param1', 'param2');
    }
    
}

class Obs1 {

    public $param1;

    public $param2;

    public $count = 0;
    
    public function testMethod($param1, $param2)
    {
        $this->count++;
        Assert::assertEquals('param1', $param1);
        Assert::assertEquals('param2', $param2);
    }
    
    public function __destruct()
    {
        Assert::assertEquals(1, $this->count);
    }

}

class Obs2 {
}