<?php

namespace BristolSU\Tests\ControlDB\Unit\AdditionalProperties;

use BristolSU\ControlDB\AdditionalProperties\AdditionalPropertySingletonStore;
use BristolSU\ControlDB\AdditionalProperties\AdditionalPropertyStore;
use BristolSU\Tests\ControlDB\TestCase;

class AdditionalPropertySingletonStoreTest extends TestCase
{
    
    /** @test */
    public function properties_can_be_added_and_retrieved(){
        $store = new AdditionalPropertySingletonStore();
        $store->addProperty('model1', 'attr1');
        $store->addProperty('model1', 'attr2');
        $this->assertEquals(['attr1', 'attr2'], $store->getProperties('model1'));
    }

    /** @test */
    public function properties_can_be_added_and_retrieved_for_multiple_models(){
        $store = new AdditionalPropertySingletonStore();
        $store->addProperty('model1', 'attr1');
        $store->addProperty('model1', 'attr2');
        $store->addProperty('model2', 'attr3');
        $store->addProperty('model2', 'attr4');
        $this->assertEquals(['attr1', 'attr2'], $store->getProperties('model1'));
        $this->assertEquals(['attr3', 'attr4'], $store->getProperties('model2'));
    }
    
    /** @test */
    public function an_empty_array_is_returned_if_no_properties_set(){
        $store = new AdditionalPropertySingletonStore();
        $this->assertEquals([], $store->getProperties('model1'));
    }
    
    /** @test */
    public function hasProperty_returns_false_if_properties_are_not_set(){
        $store = new AdditionalPropertySingletonStore();
        $this->assertFalse($store->hasProperties('model1'));
    }

    /** @test */
    public function hasProperty_returns_true_if_properties_are_set(){
        $store = new AdditionalPropertySingletonStore();
        $store->addProperty('model1', 'attr1');
        $this->assertTrue($store->hasProperties('model1'));
    }
    
    /** @test */
    public function it_is_bound_as_a_singleton(){
        $store = app(AdditionalPropertyStore::class);
        $store->addProperty('model1', 'attr1');
        
        $store2 = app(AdditionalPropertyStore::class);
        $this->assertEquals(['attr1'], $store2->getProperties('model1'));
    }
}