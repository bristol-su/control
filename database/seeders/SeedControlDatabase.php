<?php

namespace Database\Seeders;

use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\GroupGroupTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\PositionPositionTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\RoleRoleTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\UserUserTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserGroup;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserRole;
use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Position;
use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\User;
use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\ControlDB\Models\Tags\GroupTagCategory;
use BristolSU\ControlDB\Models\Tags\PositionTag;
use BristolSU\ControlDB\Models\Tags\PositionTagCategory;
use BristolSU\ControlDB\Models\Tags\UserTag;
use BristolSU\ControlDB\Models\Tags\UserTagCategory;
use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\ControlDB\Models\Tags\RoleTagCategory;

use Illuminate\Database\Seeder;

class SeedControlDatabase extends Seeder
{

    public function run()
    {
        // Create 100 users
        $users = User::factory()->count(100)->create();

        // Create 50 groups
        $groups = Group::factory()->count(50)->create();

        // Create 10 positions
        $positions = Position::factory()->count(10)->create();

        // Give each group 10 users and each role in the group 1 or 2 users
        foreach ($groups as $group) {
            foreach ($users->random(10) as $user) {
                app(UserGroup::class)->addUserToGroup($user, $group);
            }

            $roles = collect();
            foreach ($positions->random(5) as $position) {
                $roles->push(Role::factory()->create([
                    'group_id' => $group->id(),
                    'position_id' => $position->id()
                ]));
            }
            foreach ($roles as $role) {
                foreach ($users->random(rand(1, 2)) as $user) {
                    app(UserRole::class)->addUserToRole($user, $role);
                }
            }
        }

        // Tag groups
        GroupTagCategory::factory()->count(15)->create()->each(function (GroupTagCategory $groupTagCategory) {
            GroupTag::factory()->count(15)->create(['tag_category_id' => $groupTagCategory->id()])->each(function (GroupTag $groupTag) {
                foreach (Group::all()->random(10) as $group) {
                    app(GroupGroupTag::class)->addTagToGroup($groupTag, $group);
                }
            });
        });

        // Tag users
        UserTagCategory::factory()->count(15)->create()->each(function (UserTagCategory $userTagCategory) {
            UserTag::factory()->count(15)->create(['tag_category_id' => $userTagCategory->id()])->each(function (UserTag $userTag) {
                foreach (User::all()->random(10) as $user) {
                    app(UserUserTag::class)->addTagToUser($userTag, $user);
                }
            });
        });

        // Tag roles
        RoleTagCategory::factory()->count(15)->create()->each(function (RoleTagCategory $roleTagCategory) {
            RoleTag::factory()->count(15)->create(['tag_category_id' => $roleTagCategory->id()])->each(function (RoleTag $roleTag) {
                foreach (Role::all()->random(10) as $role) {
                    app(RoleRoleTag::class)->addTagToRole($roleTag, $role);
                }
            });
        });

        // Tag positions
        PositionTagCategory::factory()->count(15)->create()->each(function (PositionTagCategory $positionTagCategory) {
            PositionTag::factory()->count(15)->create(['tag_category_id' => $positionTagCategory->id()])->each(function (PositionTag $positionTag) {
                foreach (Position::all()->random(10) as $position) {
                    app(PositionPositionTag::class)->addTagToPosition($positionTag, $position);
                }
            });
        });

    }

}
