<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories;

use BristolSU\ControlDB\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use BristolSU\Tests\ControlDB\TestCase;

class RoleTest extends TestCase
{

    /** @test */
    public function getById_returns_a_role_model_with_the_corresponding_id(){
        $role = factory(Role::class)->create(['id' => 2]);
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
        $roles = factory(Role::class, 15)->create();
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
        $role = factory(Role::class)->create();
        $roleRepo = new \BristolSU\ControlDB\Repositories\Role();
        $roleRepo->delete($role->id());

        $role->refresh();
        $this->assertTrue($role->trashed());
    }


}
