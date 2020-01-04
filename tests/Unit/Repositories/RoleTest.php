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


}
