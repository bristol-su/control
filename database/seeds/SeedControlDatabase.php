<?php

use Illuminate\Database\Seeder;

class SeedControlDatabase extends Seeder
{

    public function run()
    {
        $users = factory(\BristolSU\ControlDB\Models\User::class, 100)->create();
        $groups = factory(\BristolSU\ControlDB\Models\Group::class, 50)->create();
        $positions = factory(\BristolSU\ControlDB\Models\Position::class, 10)->create();
        foreach($groups as $group) {
            $group->userRelationship()->attach($users->random(10));
            /** @var \BristolSU\ControlDB\Models\Role[] $roles */
            $roles = collect();
            foreach($positions->random(5) as $position) {
                $roles->push(factory(\BristolSU\ControlDB\Models\Role::class)->create([
                    'group_id' => $group->id(),
                    'position_id' => $position->id()
                ]));
            }
            foreach($roles as $role) {
                $role->userRelationship()->attach($users->random(rand(1,2)), [
                    'position_name' => 'somename'
                ]);
            }
        }
        
        $groupTagCategories = factory(\BristolSU\ControlDB\Models\Tags\GroupTagCategory::class, 15)->create();
        foreach($groupTagCategories as $groupTagCategory) {
            $groupTags = factory(\BristolSU\ControlDB\Models\Tags\GroupTag::class, 15)->create(['tag_category_id' => $groupTagCategory->id()]);
            foreach($groupTags as $groupTag) {
                $groupTag->groupRelationship()->attach($groups->random(10));
            }
        }

        $userTagCategories = factory(\BristolSU\ControlDB\Models\Tags\UserTagCategory::class, 15)->create();
        foreach($userTagCategories as $userTagCategory) {
            $userTags = factory(\BristolSU\ControlDB\Models\Tags\UserTag::class, 15)->create(['tag_category_id' => $userTagCategory->id()]);
            foreach($userTags as $userTag) {
                $userTag->userRelationship()->attach($users->random(10));
            }
        }


        $roleTagCategories = factory(\BristolSU\ControlDB\Models\Tags\RoleTagCategory::class, 15)->create();
        foreach($roleTagCategories as $roleTagCategory) {
            $roleTags = factory(\BristolSU\ControlDB\Models\Tags\RoleTag::class, 15)->create(['tag_category_id' => $roleTagCategory->id()]);
            foreach($roleTags as $roleTag) {
                $roleTag->roleRelationship()->attach(\BristolSU\ControlDB\Models\Role::all()->random(10));
            }
        }


        $positionTagCategories = factory(\BristolSU\ControlDB\Models\Tags\PositionTagCategory::class, 15)->create();
        foreach($positionTagCategories as $positionTagCategory) {
            $positionTags = factory(\BristolSU\ControlDB\Models\Tags\PositionTag::class, 15)->create(['tag_category_id' => $positionTagCategory->id()]);
            foreach($positionTags as $positionTag) {
                $positionTag->positionRelationship()->attach($positions->random(4));
            }
        }

    }
    
}