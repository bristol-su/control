<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\Position;

use BristolSU\ControlDB\Models\Position;
use BristolSU\ControlDB\Models\Role;
use BristolSU\Tests\ControlDB\TestCase;

class PositionRoleControllerTest extends TestCase
{

    /** @test */
    public function it_gets_all_roles_through_a_position(){
        $position = factory(Position::class)->create();
        $roles = factory(Role::class, 5)->create(['position_id' => $position->id()]);
        factory(Role::class, 2)->create();
        
        $response = $this->getJson($this->apiUrl . '/position/' . $position->id() . '/role');
        $response->assertStatus(200);
        $response->assertPaginatedResponse();
        $response->assertPaginatedJsonCount(5);
        foreach($response->paginatedJson() as $roleThroughApi) {
            $this->assertArrayHasKey('id', $roleThroughApi);
            $this->assertEquals($roles->shift()->id(), $roleThroughApi['id']);
        }
    }
    
}