<?php

namespace BristolSU\Tests\ControlDB\Unit\Observers\NotifyObservers\Framework;

use BristolSU\ControlDB\Observers\NotifyObservers\Framework\ObserverStore;
use BristolSU\Tests\ControlDB\TestCase;

class ObserverStoreTest extends TestCase
{
    
    /** @test */
    public function observers_can_be_attached(){
        $observer1 = 'Observer1';
        $observer2 = 'Observer2';
        $observer3 = 'Observer3';
        $observer4 = 'Observer4';
        $observer5 = 'Observer5';
        
        $observerStore = new ObserverStore();
        $observerStore->attach('notifier1', $observer1);
        $observerStore->attach('notifier1', $observer2);
        $observerStore->attach('notifier1', $observer3);
        $observerStore->attach('notifier2', $observer4);
        $observerStore->attach('notifier2', $observer5);
        
        $this->assertEquals([
            'Observer1', 'Observer2', 'Observer3'
        ], $observerStore->forNotifier('notifier1'));
        $this->assertEquals([
            'Observer4', 'Observer5'
        ], $observerStore->forNotifier('notifier2'));
    }

    /** @test */
    public function observers_can_be_detached(){
        $observer1 = 'Observer1';
        $observer2 = 'Observer2';
        $observer3 = 'Observer3';
        $observer4 = 'Observer4';
        $observer5 = 'Observer5';

        $observerStore = new ObserverStore();
        $observerStore->attach('notifier1', $observer1);
        $observerStore->attach('notifier1', $observer2);
        $observerStore->attach('notifier1', $observer3);
        $observerStore->attach('notifier2', $observer4);
        $observerStore->attach('notifier2', $observer5);

        $this->assertEquals([
            'Observer1', 'Observer2', 'Observer3'
        ], $observerStore->forNotifier('notifier1'));
        $this->assertEquals([
            'Observer4', 'Observer5'
        ], $observerStore->forNotifier('notifier2'));

        $observerStore->detach('notifier1', $observer1);
        $observerStore->detach('notifier1', $observer3);
        $observerStore->detach('notifier2', $observer5);

        $this->assertEquals([
            'Observer2'
        ], $observerStore->forNotifier('notifier1'));
        $this->assertEquals([
            'Observer4'
        ], $observerStore->forNotifier('notifier2'));
    }
    
    /** @test */
    public function the_store_is_a_singleton(){
        $observer1 = 'Observer1';
        $observer2 = 'Observer2';

        $observerStore = app(ObserverStore::class);
        $observerStore->attach('notifier1', $observer1);
        $observerStore->attach('notifier1', $observer2);

        $this->assertEquals([
            'Observer1', 'Observer2'
        ], $observerStore->forNotifier('notifier1'));

        $this->assertEquals([
            'Observer1', 'Observer2'
        ], app(ObserverStore::class)->forNotifier('notifier1'));
    }
    
    
    
}