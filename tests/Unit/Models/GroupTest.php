<?php

namespace BristolSU\Tests\ControlDB\Unit\Models;

use BristolSU\ControlDB\Models\DataGroup;
use BristolSU\ControlDB\Models\Group;
use BristolSU\Tests\ControlDB\TestCase;

class GroupTest extends TestCase
{

    /** @test */
    public function an_id_can_be_retrieved_from_the_model()
    {
        $group = factory(Group::class)->create([
            'id' => 4
        ]);

        $this->assertEquals(4, $group->id());
    }

    /** @test */
    public function a_data_provider_id_can_be_retrieved_from_the_model(){
        $group = factory(Group::class)->create([
            'data_provider_id' => 5
        ]);

        $this->assertEquals(5, $group->dataProviderId());
    }

    /** @test */
    public function a_data_provider_id_can_set_on_from_the_model(){
        $group = factory(Group::class)->create([
            'data_provider_id' => 5
        ]);
        
        $group->setDataProviderId(5);

        $this->assertEquals(5, $group->dataProviderId());
    }
   
    /** @test */
    public function data_is_returned_in_the_array(){
        $dataGroup = factory(DataGroup::class)->create(
            ['name' => 'Group1', 'email' => 'test@testing.com']
        );
        $group = factory(Group::class)->create([
            'data_provider_id' => $dataGroup->id()
        ]);

        $attributes = $group->toArray();
        $this->assertArrayHasKey('data', $attributes);
        $this->assertIsArray($attributes['data']);
        $this->assertArrayHasKey('name', $attributes['data']);
        $this->assertArrayHasKey('email', $attributes['data']);
        $this->assertEquals('Group1', $attributes['data']['name']);
        $this->assertEquals('test@testing.com', $attributes['data']['email']);
    }

}
