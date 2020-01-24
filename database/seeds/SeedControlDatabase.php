<?php

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
        $users = factory(User::class, 100)->create();
        
        // Create 50 groups
        $groups = factory(Group::class, 50)->create();
        
        // Create 10 positions
        $positions = factory(Position::class, 10)->create();
        
        // Give each group 10 users and each role in the group 1 or 2 users
        foreach($groups as $group) {
            $group->userRelationship()->attach($users->random(10));
            
            $roles = collect();
            foreach($positions->random(5) as $position) {
                $roles->push(factory(Role::class)->create([
                    'group_id' => $group->id(),
                    'position_id' => $position->id()
                ]));
            }
            foreach($roles as $role) {
                $role->userRelationship()->attach($users->random(rand(1,2)));
            }
        }
        
        // Tag groups
        factory(GroupTagCategory::class, 15)->create()->each(function(GroupTagCategory $groupTagCategory) use ($groups) {
            factory(GroupTag::class, 15)->create(['tag_category_id' => $groupTagCategory->id()])->each(function(GroupTag $groupTag) use ($groups) {
                $groupTag->groupRelationship()->attach($groups->random(10));
            });
        });

        // Tag users
        factory(UserTagCategory::class, 15)->create()->each(function(UserTagCategory $userTagCategory) use ($users) {
            factory(UserTag::class, 15)->create(['tag_category_id' => $userTagCategory->id()])->each(function(UserTag $userTag) use ($users) {
                $userTag->userRelationship()->attach($users->random(10));
            });
        });

        // Tag roles
        factory(RoleTagCategory::class, 15)->create()->each(function(RoleTagCategory $roleTagCategory) use ($roles) {
            factory(RoleTag::class, 15)->create(['tag_category_id' => $roleTagCategory->id()])->each(function(RoleTag $roleTag) use ($roles) {
                $roleTag->roleRelationship()->attach($roles->random(10));
            });
        });

        // Tag positions
        factory(PositionTagCategory::class, 15)->create()->each(function(PositionTagCategory $positionTagCategory) use ($positions) {
            factory(PositionTag::class, 15)->create(['tag_category_id' => $positionTagCategory->id()])->each(function(PositionTag $positionTag) use ($positions) {
                $positionTag->positionRelationship()->attach($positions->random(10));
            });
        });

    }
    
}