<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\Role;

use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Role;
use BristolSU\Tests\ControlDB\TestCase;

class RoleGroupControllerTest extends TestCase
{

    /** @test */
    public function it_gets_the_group_from_the_role(){
        $group = Group::factory()->create();
        $role = Role::factory()->create(['group_id' => $group->id()]);
        
        $response = $this->getJson($this->apiUrl . '/group/' . $group->id() . '/role');
        
        $response->assertStatus(200);
        
        $response->assertJsonFragment(['id' => $role->id()]);
    }
    
}
