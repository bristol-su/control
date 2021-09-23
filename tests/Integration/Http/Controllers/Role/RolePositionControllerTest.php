<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\Role;

use BristolSU\ControlDB\Models\Position;
use BristolSU\ControlDB\Models\Role;
use BristolSU\Tests\ControlDB\TestCase;

class RolePositionControllerTest extends TestCase
{

    /** @test */
    public function it_gets_the_position_from_the_role(){
        $position = Position::factory()->create();
        $role = Role::factory()->create(['position_id' => $position->id()]);
        
        $response = $this->getJson($this->apiUrl . '/position/' . $position->id() . '/role');
        
        $response->assertStatus(200);
        
        $response->assertJsonFragment(['id' => $role->id()]);
    }
    
}
