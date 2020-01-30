<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\Group;

use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Role;
use BristolSU\Tests\ControlDB\TestCase;

class GroupRoleControllerTest extends TestCase
{

    /** @test */
    public function it_gets_all_roles_through_a_group(){
        $group = factory(Group::class)->create();
        $roles = factory(Role::class, 5)->create(['group_id' => $group->id()]);
        factory(Role::class, 2)->create();
        
        $response = $this->getJson($this->apiUrl . '/group/' . $group->id() . '/role');
        $response->assertStatus(200);
        
        $response->assertJsonCount(5);
        foreach($response->json() as $roleThroughApi) {
            $this->assertArrayHasKey('id', $roleThroughApi);
            $this->assertEquals($roles->shift()->id(), $roleThroughApi['id']);
        }
    }
    
}