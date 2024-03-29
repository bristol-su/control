<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\Group;

use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;

class GroupUserControllerTest extends TestCase
{

    /** @test */
    public function it_gets_all_users_through_a_group(){
        $group = Group::factory()->create();
        $users = User::factory()->count(5)->create();
        User::factory()->count(3)->create();

        foreach($users as $user) {
            $group->addUser($user);
            $this->assertDatabaseHas('control_group_user', [
                'group_id' => $group->id(),
                'user_id' => $user->id(),
            ]);
        }

        $response = $this->getJson($this->apiUrl . '/group/' . $group->id() . '/user');
        $response->assertStatus(200);
        $response->assertPaginatedResponse();

        $response->assertPaginatedJsonCount(5, 'data');
        foreach($response->paginatedJson() as $userThroughApi) {
            $this->assertArrayHasKey('id', $userThroughApi);
            $this->assertEquals($users->shift()->id(), $userThroughApi['id']);
        }
    }

    /** @test */
    public function it_adds_a_user_to_a_group(){
        $group = Group::factory()->create();
        $user = User::factory()->create();

        $this->assertDatabaseMissing('control_group_user', [
            'group_id' => $group->id(),
            'user_id' => $user->id(),
        ]);

        $response = $this->patchJson(
            $this->apiUrl . '/group/' . $group->id() . '/user/' . $user->id()
        );

        $response->assertStatus(200);

        $this->assertDatabaseHas('control_group_user', [
            'group_id' => $group->id(),
            'user_id' => $user->id(),
        ]);
    }

    /** @test */
    public function it_removes_a_user_from_a_group(){
        $group = Group::factory()->create();
        $user = User::factory()->create();

        $group->addUser($user);

        $this->assertDatabaseHas('control_group_user', [
            'group_id' => $group->id(),
            'user_id' => $user->id(),
        ]);

        $response = $this->deleteJson(
            $this->apiUrl . '/group/' . $group->id() . '/user/' . $user->id()
        );

        $response->assertStatus(200);

        $this->assertSoftDeleted('control_group_user', [
            'group_id' => $group->id(),
            'user_id' => $user->id(),
        ]);


    }

}
