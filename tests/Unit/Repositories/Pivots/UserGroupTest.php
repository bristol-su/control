<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories\Pivots;

use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\User;
use BristolSU\ControlDB\Repositories\Pivots\UserGroup;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Facades\DB;

class UserGroupTest extends TestCase
{

    /** @test */
    public function it_gets_all_users_attached_to_a_group(){
        $usersInGroup = User::factory()->count(10)->create();
        $usersNotInGroup = User::factory()->count(10)->create();
        $group = Group::factory()->create();

        $usersInGroup->each(function(User $user) use ($group) {
            \BristolSU\ControlDB\Models\Pivots\UserGroup::create([
                'user_id' => $user->id(), 'group_id' => $group->id()
            ]);
        });

        $usersThroughRepository = (new UserGroup())->getUsersThroughGroup($group);
        $this->assertEquals(10, $usersThroughRepository->count());

        foreach($usersInGroup as $user) {
            $this->assertTrue($user->is($usersThroughRepository->shift()));
        }
    }

    /** @test */
    public function it_gets_all_groups_a_user_is_attached_to(){
        $groupsInUser = Group::factory()->count(10)->create();
        $groupsNotInUser = Group::factory()->count(10)->create();
        $user = User::factory()->create();

        $groupsInUser->each(function(Group $group) use ($user) {
            \BristolSU\ControlDB\Models\Pivots\UserGroup::create([
                'group_id' => $group->id(), 'user_id' => $user->id()
            ]);
        });

        $groupsThroughRepository = (new UserGroup())->getGroupsThroughUser($user);
        $this->assertEquals(10, $groupsThroughRepository->count());

        foreach($groupsInUser as $group) {
            $this->assertTrue($group->is($groupsThroughRepository->shift()));
        }
    }

    /** @test */
    public function it_adds_a_user_to_a_group(){
        $group = Group::factory()->create();
        $user = User::factory()->create();
        $userGroup = new UserGroup();
        $this->assertEquals(0, $userGroup->getUsersThroughGroup($group)->count());

        $userGroup->addUserToGroup($user, $group);

        $this->assertEquals(1, $userGroup->getUsersThroughGroup($group)->count());
        $this->assertInstanceOf(User::class, $userGroup->getUsersThroughGroup($group)->first());
        $this->assertTrue($user->is($userGroup->getUsersThroughGroup($group)->first()));
    }

    /** @test */
    public function it_removes_a_user_from_a_group(){
        $group = Group::factory()->create();
        $user = User::factory()->create();
        $userGroup = new UserGroup();

        \BristolSU\ControlDB\Models\Pivots\UserGroup::create(['user_id' => $user->id(), 'group_id' => $group->id()]);

        $this->assertEquals(1, $userGroup->getUsersThroughGroup($group)->count());
        $this->assertInstanceOf(User::class, $userGroup->getUsersThroughGroup($group)->first());
        $this->assertTrue($user->is($userGroup->getUsersThroughGroup($group)->first()));

        $userGroup->removeUserFromGroup($user, $group);

        $this->assertEquals(0, $userGroup->getUsersThroughGroup($group)->count());
    }

}
