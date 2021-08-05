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
    public function it_returns_all_roles()
    {
        $roles = Role::factory()->count(5)->create();
        $response = $this->getJson($this->apiUrl . '/role');
        $response->assertStatus(200);

        $response->assertPaginatedResponse();
        $response->assertPaginatedJsonCount(5);
        foreach ($response->paginatedJson() as $roleThroughApi) {
            $this->assertArrayHasKey('id', $roleThroughApi);
            $this->assertEquals($roles->shift()->id(), $roleThroughApi['id']);
        }
    }

    /** @test */
    public function it_limits_roles_by_the_pagination_options(){
        $roles = Role::factory()->count(50)->create();
        $response = $this->getJson($this->apiUrl . '/role?page=2&per_page=15');
        $response->assertStatus(200);

        $response->assertJsonCount(15, 'data');
        $paginatedRoles = $roles->slice(15, 15)->values();
        foreach ($response->json()['data'] as $roleThroughApi) {
            $this->assertArrayHasKey('id', $roleThroughApi);
            $this->assertEquals($paginatedRoles->shift()->id(), $roleThroughApi['id']);
        }
    }

    /** @test */
    public function it_returns_a_single_role(){
        $dataRole = DataRole::factory()->create();
        $role = Role::factory()->create(['data_provider_id' => $dataRole->id()]);
        $response = $this->getJson($this->apiUrl . '/role/' . $role->id());

        $response->assertStatus(200);
        $response->assertJson(['id' => $role->id()]);
        $response->assertJson(['data_provider_id' => $dataRole->id()]);
    }

    /** @test */
    public function it_updates_a_role(){
        $group1 = Group::factory()->create();
        $group2 = Group::factory()->create();
        $position1 = Position::factory()->create();
        $position2 = Position::factory()->create();

        $dataRole = DataRole::factory()->create(['role_name' => 'Name1', 'email' => 'email@email.com']);
        $role = Role::factory()->create([
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
        $group = Group::factory()->create();
        $position = Position::factory()->create();

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
        $role = Role::factory()->create();

        $this->assertDatabaseHas('control_roles', [
            'id' => $role->id
        ]);

        $response = $this->deleteJson($this->apiUrl . '/role/' . $role->id());

        $this->assertSoftDeleted('control_roles', [
            'id' => $role->id
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_updates_a_role_with_additional_attributes()
    {
        DataRole::addProperty('student_id');
        $dataRole = DataRole::factory()->create(['role_name' => 'Name1', 'email' => 'email@email.com', 'additional_attributes' => json_encode(['student_id' => 'xyz123'])]);
        $role = Role::factory()->create(['data_provider_id' => $dataRole->id()]);

        $this->assertDatabaseHas('control_data_role', [
            'role_name' => 'Name1', 'email' => 'email@email.com', 'additional_attributes' => json_encode(['student_id' => 'xyz123'])
        ]);

        $response = $this->patchJson($this->apiUrl . '/role/' . $role->id(), [
            'role_name' => 'Name2', 'email' => 'email2@email.com', 'student_id' => 'xzy789'
        ]);

        $response->assertJsonFragment([
            'role_name' => 'Name2', 'email' => 'email2@email.com', 'student_id' => 'xzy789'
        ]);

        $this->assertDatabaseHas('control_data_role', [
            'role_name' => 'Name2', 'email' => 'email2@email.com', 'additional_attributes' => json_encode(['student_id' => 'xzy789'])
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_creates_a_role_with_additional_attributes()
    {
        $group = Group::factory()->create();
        $position = Position::factory()->create();

        DataRole::addProperty('account_code');

        $response = $this->postJson($this->apiUrl . '/role', [
            'role_name' => 'Name2', 'email' => 'email2@email.com', 'account_code' => 'CHA', 'position_id' => $position->id(), 'group_id' => $group->id()
        ]);

        $response->assertStatus(201);

        $response->assertJsonFragment([
            'role_name' => 'Name2', 'email' => 'email2@email.com', 'account_code' => 'CHA', 'position_id' => $position->id(), 'group_id' => $group->id()
        ]);

        $this->assertDatabaseHas('control_data_role', [
            'role_name' => 'Name2', 'email' => 'email2@email.com', 'additional_attributes' => json_encode(['account_code' => 'CHA'])
        ]);

        $dataRole = DataRole::findOrFail($response->json('data.id'));
        $response->assertJsonFragment(['id' => $dataRole->id()]);
    }
}
