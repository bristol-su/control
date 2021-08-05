<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\Role;

use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;

class RoleUserControllerTest extends TestCase
{

    /** @test */
    public function it_gets_all_users_through_a_role(){
        $role = Role::factory()->create();
        $users = User::factory()->count(5)->create();
        User::factory()->count(3)->create();

        foreach($users as $user) {
            $role->addUser($user);
            $this->assertDatabaseHas('control_role_user', [
                'role_id' => $role->id(),
                'user_id' => $user->id(),
            ]);
        }

        $response = $this->getJson($this->apiUrl . '/role/' . $role->id() . '/user');
        $response->assertStatus(200);
        $response->assertPaginatedResponse();

        $response->assertPaginatedJsonCount(5);
        foreach($response->paginatedJson() as $userThroughApi) {
            $this->assertArrayHasKey('id', $userThroughApi);
            $this->assertEquals($users->shift()->id(), $userThroughApi['id']);
        }
    }

    /** @test */
    public function it_adds_a_user_to_a_role(){
        $role = Role::factory()->create();
        $user = User::factory()->create();

        $this->assertDatabaseMissing('control_role_user', [
            'role_id' => $role->id(),
            'user_id' => $user->id(),
        ]);

        $response = $this->patchJson(
            $this->apiUrl . '/role/' . $role->id() . '/user/' . $user->id()
        );

        $response->assertStatus(200);

        $this->assertDatabaseHas('control_role_user', [
            'role_id' => $role->id(),
            'user_id' => $user->id(),
        ]);
    }

    /** @test */
    public function it_removes_a_user_from_a_role(){
        $role = Role::factory()->create();
        $user = User::factory()->create();

        $role->addUser($user);

        $this->assertDatabaseHas('control_role_user', [
            'role_id' => $role->id(),
            'user_id' => $user->id(),
        ]);

        $response = $this->deleteJson(
            $this->apiUrl . '/role/' . $role->id() . '/user/' . $user->id()
        );

        $response->assertStatus(200);

        $this->assertSoftDeleted('control_role_user', [
            'role_id' => $role->id(),
            'user_id' => $user->id(),
        ]);


    }

}
