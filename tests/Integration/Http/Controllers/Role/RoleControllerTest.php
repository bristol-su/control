<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\Role;

use BristolSU\ControlDB\Models\DataRole;
use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Position;
use BristolSU\ControlDB\Models\Role;
use BristolSU\Tests\ControlDB\TestCase;

class RoleControllerTest extends TestCase
{

    /** @test */
    public function it_returns_all_roles(){
        $roles = factory(Role::class, 5)->create();
        $response = $this->getJson($this->apiUrl . '/role');
        $response->assertStatus(200);

        $response->assertJsonCount(5);
        foreach($response->json() as $roleThroughApi) {
            $this->assertArrayHasKey('id', $roleThroughApi);
            $this->assertEquals($roles->shift()->id(), $roleThroughApi['id']);
        }
    }

    /** @test */
    public function it_returns_a_single_role(){
        $dataRole = factory(DataRole::class)->create();
        $role = factory(Role::class)->create(['data_provider_id' => $dataRole->id()]);
        $response = $this->getJson($this->apiUrl . '/role/' . $role->id());

        $response->assertStatus(200);
        $response->assertJson(['id' => $role->id()]);
        $response->assertJson(['data_provider_id' => $dataRole->id()]);
    }

    /** @test */
    public function it_updates_a_role(){
        $group1 = factory(Group::class)->create();
        $group2 = factory(Group::class)->create();
        $position1 = factory(Position::class)->create();
        $position2 = factory(Position::class)->create();
        
        $dataRole = factory(DataRole::class)->create(['role_name' => 'Name1', 'email' => 'email@email.com']);
        $role = factory(Role::class)->create([
            'data_provider_id' => $dataRole->id(), 'position_id' => $position1->id(), 'group_id' => $group1->id()]);

        $this->assertDatabaseHas('control_data_role', [
            'role_name' => 'Name1', 'email' => 'email@email.com'
        ]);

        $this->assertDatabaseHas('control_roles', [
            'id' => $role->id(), 'position_id' => $position1->id(), 'group_id' => $group1->id()
        ]);

        $response = $this->patchJson($this->apiUrl . '/role/' . $role->id(), [
            'role_name' => 'Name2', 'email' => 'email2@email.com',  'position_id' => $position2->id(), 'group_id' => $group2->id()
        ]);

        $this->assertDatabaseHas('control_data_role', [
            'role_name' => 'Name2', 'email' => 'email2@email.com'
        ]);
        
        $this->assertDatabaseHas('control_roles', [
            'id' => $role->id(), 'position_id' => $position2->id(), 'group_id' => $group2->id()
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_creates_a_role(){
        $group = factory(Group::class)->create();
        $position = factory(Position::class)->create();

        $this->assertDatabaseMissing('control_roles', [
            'position_id' => $position->id(), 'group_id' => $group->id()
        ]);

        
        $response = $this->postJson($this->apiUrl . '/role', [
            'role_name' => 'Name2', 'email' => 'email2@email.com', 'position_id' => $position->id(), 'group_id' => $group->id()
        ]);

        $response->assertStatus(201);

        $response->assertJsonFragment([
            'role_name' => 'Name2', 'email' => 'email2@email.com', 'position_id' => $position->id(), 'group_id' => $group->id()
        ]);

        $this->assertDatabaseHas('control_data_role', [
            'role_name' => 'Name2', 'email' => 'email2@email.com',
        ]);

        $this->assertDatabaseHas('control_roles', [
            'position_id' => $position->id(), 'group_id' => $group->id()
        ]);

        $dataRole = DataRole::findOrFail($response->json('data.id'));
        $response->assertJsonFragment(['id' => $dataRole->id()]);
    }


    /** @test */
    public function it_deletes_a_role(){
        $role = factory(Role::class)->create();

        $this->assertDatabaseHas('control_roles', [
            'id' => $role->id
        ]);

        $response = $this->deleteJson($this->apiUrl . '/role/' . $role->id());

        $this->assertSoftDeleted('control_roles', [
            'id' => $role->id
        ]);

        $response->assertStatus(200);
    }

}