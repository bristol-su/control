<?php

namespace BristolSU\Tests\ControlDB\Unit\Models;

use BristolSU\ControlDB\Models\DataRole;
use BristolSU\ControlDB\Models\Role;
use BristolSU\Tests\ControlDB\TestCase;

class RoleTest extends TestCase
{

    /** @test */
    public function an_id_can_be_retrieved_from_the_model()
    {
        $role = Role::factory()->create([
            'id' => 4
        ]);

        $this->assertEquals(4, $role->id());
    }

    /** @test */
    public function a_group_id_can_be_retrieved_from_the_model()
    {
        $role = Role::factory()->create([
            'group_id' => 4
        ]);

        $this->assertEquals(4, $role->groupId());
    }

    /** @test */
    public function a_position_id_can_be_retrieved_from_the_model()
    {
        $role = Role::factory()->create([
            'position_id' => 4
        ]);

        $this->assertEquals(4, $role->positionId());
    }

    /** @test */
    public function a_group_id_can_be_set_on_the_model()
    {
        $role = Role::factory()->create([
            'group_id' => 1
        ]);
        
        $role->setGroupId(4);

        $this->assertEquals(4, $role->groupId());
    }

    /** @test */
    public function a_position_id_can_be_set_on_the_model()
    {
        $role = Role::factory()->create([
            'position_id' => 1
        ]);
        
        $role->setPositionId(4);
        
        $this->assertEquals(4, $role->positionId());
    }

    /** @test */
    public function a_data_provider_id_can_be_retrieved_from_the_model(){
        $role = Role::factory()->create([
            'data_provider_id' => 2
        ]);

        $this->assertEquals(2, $role->dataProviderId());
    }

    /** @test */
    public function a_data_provider_id_can_set_on_from_the_model(){
        $role = Role::factory()->create([
            'data_provider_id' => 5
        ]);

        $role->setDataProviderId(5);

        $this->assertEquals(5, $role->dataProviderId());
    }

    /** @test */
    public function data_is_returned_in_the_array(){
        $dataRole = DataRole::factory()->create(
            ['role_name' => 'Role1', 'email' => 'test@testing.com']
        );
        $role = Role::factory()->create([
            'data_provider_id' => $dataRole->id()
        ]);

        $attributes = $role->toArray();
        $this->assertArrayHasKey('data', $attributes);
        $this->assertIsArray($attributes['data']);
        $this->assertArrayHasKey('role_name', $attributes['data']);
        $this->assertArrayHasKey('email', $attributes['data']);
        $this->assertEquals('Role1', $attributes['data']['role_name']);
        $this->assertEquals('test@testing.com', $attributes['data']['email']);
    }


}
