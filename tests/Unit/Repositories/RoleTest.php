<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories;

use BristolSU\ControlDB\Models\DataPosition;
use BristolSU\ControlDB\Models\DataRole;
use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Position;
use BristolSU\ControlDB\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use BristolSU\Tests\ControlDB\TestCase;

class RoleTest extends TestCase
{

    /** @test */
    public function getById_returns_a_role_model_with_the_corresponding_id(){
        $role = Role::factory()->create(['id' => 2]);
        $roleRepo = new \BristolSU\ControlDB\Repositories\Role();
        $this->assertTrue(
            $role->is($roleRepo->getById(2))
        );
    }

    /** @test */
    public function getById_throws_a_modelNotFoundException_if_role_does_not_exist(){
        $this->expectException(ModelNotFoundException::class);
        $roleRepo = new \BristolSU\ControlDB\Repositories\Role();
        $roleRepo->getById(5);
    }

    /** @test */
    public function all_returns_all_roles(){
        $roles = Role::factory()->count(15)->create();
        $roleRepo = new \BristolSU\ControlDB\Repositories\Role();
        $repoRoles = $roleRepo->all();
        foreach($roles as $role) {
            $this->assertTrue($role->is(
                $repoRoles->shift()
            ));
        }
    }

    /** @test */
    public function create_creates_a_role_model(){
        $roleRepo = new \BristolSU\ControlDB\Repositories\Role();
        $roleRepo->create(1, 2, 3);

        $this->assertDatabaseHas('control_roles', [
            'position_id' => 1,
            'group_id' => 2,
            'data_provider_id' => 3
        ]);
    }

    /** @test */
    public function create_returns_a_role_model(){
        $roleRepo = new \BristolSU\ControlDB\Repositories\Role();
        $role = $roleRepo->create(1, 2, 3);

        $this->assertInstanceOf(Role::class, $role);
        $this->assertEquals(1, $role->positionId());
        $this->assertEquals(2, $role->groupId());
        $this->assertEquals(3, $role->dataProviderId());
    }

    /** @test */
    public function delete_deletes_a_role_model(){
        $role = Role::factory()->create();
        $roleRepo = new \BristolSU\ControlDB\Repositories\Role();
        $roleRepo->delete($role->id());

        $role->refresh();
        $this->assertTrue($role->trashed());
    }


    /** @test */
    public function getByDataProviderId_returns_a_role_model_with_a_given_data_provider_id()
    {
        $dataRole = DataRole::factory()->create();
        $role = Role::factory()->create(['data_provider_id' => $dataRole->id]);

        $roleRepo = new \BristolSU\ControlDB\Repositories\Role();
        $dbRole = $roleRepo->getByDataProviderId($dataRole->id);

        $this->assertInstanceOf(Role::class, $dbRole);
        $this->assertEquals($dataRole->id, $dbRole->dataProviderId());
        $this->assertEquals($role->id, $dbRole->dataProviderId());
    }

    /** @test */
    public function getByDataProviderId_throws_an_exception_if_no_model_found()
    {
        $this->expectException(ModelNotFoundException::class);
        Role::factory()->create(['data_provider_id' => 10]);

        $roleRepo = new \BristolSU\ControlDB\Repositories\Role();
        $roleRepo->getByDataProviderId(11);

    }

    /** @test */
    public function allThroughGroup_returns_all_roles_with_the_given_group(){
        $group = Group::factory()->create();
        $roles = Role::factory()->count(15)->create(['group_id' => $group->id()]);
        Role::factory()->count(15)->create();

        $roleRepo = new \BristolSU\ControlDB\Repositories\Role();
        $repoRoles = $roleRepo->allThroughGroup($group);
        $this->assertContainsOnlyInstancesOf(Role::class, $repoRoles);
        foreach($roles as $role) {
            $this->assertTrue($role->is(
                $repoRoles->shift()
            ));
        }
    }

    /** @test */
    public function allThroughPosition_returns_all_roles_with_the_given_position(){
        $position = Position::factory()->create();
        $roles = Role::factory()->count(15)->create(['position_id' => $position->id()]);
        Role::factory()->count(15)->create();

        $roleRepo = new \BristolSU\ControlDB\Repositories\Role();
        $repoRoles = $roleRepo->allThroughPosition($position);
        $this->assertContainsOnlyInstancesOf(Role::class, $repoRoles);
        foreach($roles as $role) {
            $this->assertTrue($role->is(
                $repoRoles->shift()
            ));
        }
    }

    /** @test */
    public function count_returns_the_number_of_roles(){
        $roles = Role::factory()->count(18)->create();
        $roleRepo = new \BristolSU\ControlDB\Repositories\Role();

        $this->assertEquals(18, $roleRepo->count());
    }

    /** @test */
    public function paginate_returns_the_number_of_roles_specified_for_the_given_page(){
        $roles = Role::factory()->count(40)->create();
        $roleRepo = new \BristolSU\ControlDB\Repositories\Role();

        $paginatedRoles = $roleRepo->paginate(2, 10);
        $this->assertEquals(10, $paginatedRoles->count());
        $this->assertTrue($roles[10]->is($paginatedRoles->shift()));
        $this->assertTrue($roles[11]->is($paginatedRoles->shift()));
        $this->assertTrue($roles[12]->is($paginatedRoles->shift()));
        $this->assertTrue($roles[13]->is($paginatedRoles->shift()));
        $this->assertTrue($roles[14]->is($paginatedRoles->shift()));
        $this->assertTrue($roles[15]->is($paginatedRoles->shift()));
        $this->assertTrue($roles[16]->is($paginatedRoles->shift()));
        $this->assertTrue($roles[17]->is($paginatedRoles->shift()));
        $this->assertTrue($roles[18]->is($paginatedRoles->shift()));
        $this->assertTrue($roles[19]->is($paginatedRoles->shift()));
    }

    /** @test */
    public function update_updates_a_role(){
        $dataRole1 = DataRole::factory()->create();
        $dataRole2 = DataRole::factory()->create();
        $position1 = Position::factory()->create();
        $position2 = Position::factory()->create();
        $group1 = Group::factory()->create();
        $group2 = Group::factory()->create();
        $role = Role::factory()->create(['data_provider_id' => $dataRole1->id(), 'position_id' => $position1->id(), 'group_id' => $group1->id()]);

        $this->assertDatabaseHas('control_roles', [
            'id' => $role->id(), 'data_provider_id' => $dataRole1->id(), 'position_id' => $position1->id(), 'group_id' => $group1->id()
        ]);

        $repository = new \BristolSU\ControlDB\Repositories\Role();
        $repository->update($role->id(), $position2->id(), $group2->id(), $dataRole2->id());

        $this->assertDatabaseMissing('control_roles', [
            'id' => $role->id(), 'data_provider_id' => $dataRole1->id(), 'position_id' => $position1->id(), 'group_id' => $group1->id()
        ]);
        $this->assertDatabaseHas('control_roles', [
            'id' => $role->id(), 'data_provider_id' => $dataRole2->id(), 'position_id' => $position2->id(), 'group_id' => $group2->id()
        ]);
    }

    /** @test */
    public function update_returns_the_updated_role(){
        $dataRole1 = DataRole::factory()->create();
        $dataRole2 = DataRole::factory()->create();
        $position1 = Position::factory()->create();
        $position2 = Position::factory()->create();
        $group1 = Group::factory()->create();
        $group2 = Group::factory()->create();
        $role = Role::factory()->create(['data_provider_id' => $dataRole1->id(), 'position_id' => $position1->id(), 'group_id' => $group1->id()]);

        $this->assertEquals($dataRole1->id(), $role->dataProviderId());
        $this->assertEquals($position1->id(), $role->positionId());
        $this->assertEquals($group1->id(), $role->groupId());

        $repository = new \BristolSU\ControlDB\Repositories\Role();
        $updatedRole = $repository->update($role->id(), $position2->id(), $group2->id(), $dataRole2->id());

        $this->assertEquals($dataRole2->id(), $updatedRole->dataProviderId());
        $this->assertEquals($position2->id(), $updatedRole->positionId());
        $this->assertEquals($group2->id(), $updatedRole->groupId());
    }

}
