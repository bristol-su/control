<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories\Pivots;

use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\User;
use BristolSU\ControlDB\Repositories\Pivots\UserRole;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Facades\DB;

class UserRoleTest extends TestCase
{

    /** @test */
    public function it_gets_all_users_attached_to_a_role(){
        $usersInRole = factory(User::class, 10)->create();
        $usersNotInRole = factory(User::class, 10)->create();
        $role = factory(Role::class)->create();
        
        $usersInRole->each(function(User $user) use ($role) {
            \BristolSU\ControlDB\Models\Pivots\UserRole::create([
                'user_id' => $user->id(), 'role_id' => $role->id()
            ]);
        });
        
        $usersThroughRepository = (new UserRole())->getUsersThroughRole($role);
        $this->assertEquals(10, $usersThroughRepository->count());
        
        foreach($usersInRole as $user) {
            $this->assertTrue($user->is($usersThroughRepository->shift()));
        }
    }
    
    /** @test */
    public function it_gets_all_roles_a_user_is_attached_to(){
        $rolesInUser = factory(Role::class, 10)->create();
        $rolesNotInUser = factory(Role::class, 10)->create();
        $user = factory(User::class)->create();

        $rolesInUser->each(function(Role $role) use ($user) {
            \BristolSU\ControlDB\Models\Pivots\UserRole::create([
                'role_id' => $role->id(), 'user_id' => $user->id()
            ]);
        });

        $rolesThroughRepository = (new UserRole())->getRolesThroughUser($user);
        $this->assertEquals(10, $rolesThroughRepository->count());

        foreach($rolesInUser as $role) {
            $this->assertTrue($role->is($rolesThroughRepository->shift()));
        }
    }
    
    /** @test */
    public function it_adds_a_user_to_a_role(){
        $role = factory(Role::class)->create();
        $user = factory(User::class)->create();

        $userRole = new UserRole();
        $this->assertEquals(0, $userRole->getUsersThroughRole($role)->count());

        $userRole->addUserToRole($user, $role);
        
        $this->assertEquals(1, $userRole->getUsersThroughRole($role)->count());
        $this->assertInstanceOf(User::class, $userRole->getUsersThroughRole($role)->first());
        $this->assertTrue($user->is($userRole->getUsersThroughRole($role)->first()));
    }

    /** @test */
    public function it_removes_a_user_from_a_role(){
        $role = factory(Role::class)->create();
        $user = factory(User::class)->create();
        $userRole = new UserRole();

        \BristolSU\ControlDB\Models\Pivots\UserRole::create(['user_id' => $user->id(), 'role_id' => $role->id()]);
        
        $this->assertEquals(1, $userRole->getUsersThroughRole($role)->count());
        $this->assertInstanceOf(User::class, $userRole->getUsersThroughRole($role)->first());
        $this->assertTrue($user->is($userRole->getUsersThroughRole($role)->first()));

        $userRole->removeUserFromRole($user, $role);

        $this->assertEquals(0, $userRole->getUsersThroughRole($role)->count());
    }
    
}