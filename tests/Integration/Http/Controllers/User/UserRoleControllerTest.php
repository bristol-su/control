<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\User;

use BristolSU\ControlDB\Models\User;
use BristolSU\ControlDB\Models\Role;
use BristolSU\Tests\ControlDB\TestCase;

class UserRoleControllerTest extends TestCase
{

    /** @test */
    public function it_gets_all_roles_through_a_user(){
        $user = factory(User::class)->create();
        $roles = factory(Role::class, 5)->create();
        
        foreach($roles as $role) {
            $user->addRole($role);
            $this->assertDatabaseHas('control_role_user', [
                'user_id' => $user->id(),
                'role_id' => $role->id(),
            ]);
        }
        
        $response = $this->getJson($this->apiUrl . '/user/' . $user->id() . '/role');
        $response->assertStatus(200);
        
        $response->assertJsonCount(5);
        foreach($response->json() as $roleThroughApi) {
            $this->assertArrayHasKey('id', $roleThroughApi);
            $this->assertEquals($roles->shift()->id(), $roleThroughApi['id']);
        }
    }
    
    /** @test */
    public function it_adds_a_role_to_a_user(){
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();
        
        $this->assertDatabaseMissing('control_role_user', [
            'user_id' => $user->id(),
            'role_id' => $role->id(),
        ]);
        
        $response = $this->patchJson(
            $this->apiUrl . '/user/' . $user->id() . '/role/' . $role->id()
        );

        $response->assertStatus(200);
        
        $this->assertDatabaseHas('control_role_user', [
            'user_id' => $user->id(),
            'role_id' => $role->id(),
        ]);
    }
    
    /** @test */
    public function it_removes_a_role_from_a_user(){
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();

        $user->addRole($role);
        
        $this->assertDatabaseHas('control_role_user', [
            'user_id' => $user->id(),
            'role_id' => $role->id(),
        ]);

        $response = $this->deleteJson(
            $this->apiUrl . '/user/' . $user->id() . '/role/' . $role->id()
        );

        $response->assertStatus(200);
        
        $this->assertSoftDeleted('control_role_user', [
            'user_id' => $user->id(),
            'role_id' => $role->id(),
        ]);


    }
    
}