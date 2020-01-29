<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\User;

use BristolSU\ControlDB\Models\User;
use BristolSU\ControlDB\Models\Group;
use BristolSU\Tests\ControlDB\TestCase;

class UserGroupControllerTest extends TestCase
{

    /** @test */
    public function it_gets_all_groups_through_a_user(){
        $user = factory(User::class)->create();
        $groups = factory(Group::class, 5)->create();
        
        foreach($groups as $group) {
            $user->addGroup($group);
            $this->assertDatabaseHas('control_group_user', [
                'user_id' => $user->id(),
                'group_id' => $group->id(),
            ]);
        }
        
        $response = $this->getJson($this->apiUrl . '/user/' . $user->id() . '/group');
        $response->assertStatus(200);
        
        $response->assertJsonCount(5);
        foreach($response->json() as $groupThroughApi) {
            $this->assertArrayHasKey('id', $groupThroughApi);
            $this->assertEquals($groups->shift()->id(), $groupThroughApi['id']);
        }
    }
    
    /** @test */
    public function it_adds_a_group_to_a_user(){
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        
        $this->assertDatabaseMissing('control_group_user', [
            'user_id' => $user->id(),
            'group_id' => $group->id(),
        ]);
        
        $response = $this->patchJson(
            $this->apiUrl . '/user/' . $user->id() . '/group/' . $group->id()
        );

        $response->assertStatus(200);
        
        $this->assertDatabaseHas('control_group_user', [
            'user_id' => $user->id(),
            'group_id' => $group->id(),
        ]);
    }
    
    /** @test */
    public function it_removes_a_group_from_a_user(){
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();

        $user->addGroup($group);
        
        $this->assertDatabaseHas('control_group_user', [
            'user_id' => $user->id(),
            'group_id' => $group->id(),
        ]);

        $response = $this->deleteJson(
            $this->apiUrl . '/user/' . $user->id() . '/group/' . $group->id()
        );

        $response->assertStatus(200);
        
        $this->assertSoftDeleted('control_group_user', [
            'user_id' => $user->id(),
            'group_id' => $group->id(),
        ]);


    }
    
}