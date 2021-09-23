<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\Group;

use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Role;
use BristolSU\Tests\ControlDB\TestCase;

class GroupRoleControllerTest extends TestCase
{

    /** @test */
    public function it_gets_all_roles_through_a_group(){
        $group = Group::factory()->create();
        $roles = Role::factory()->count(5)->create(['group_id' => $group->id()]);
        Role::factory()->count(2)->create();

        $response = $this->getJson($this->apiUrl . '/group/' . $group->id() . '/role');
        $response->assertStatus(200);
        $response->assertPaginatedResponse();
        $response->assertPaginatedJsonCount(5);
        foreach($response->paginatedJson() as $roleThroughApi) {
            $this->assertArrayHasKey('id', $roleThroughApi);
            $this->assertEquals($roles->shift()->id(), $roleThroughApi['id']);
        }
    }

}
