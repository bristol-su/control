<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories;

use BristolSU\ControlDB\Models\Group;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use BristolSU\Tests\ControlDB\TestCase;

class GroupTest extends TestCase
{

    /** @test */
    public function getById_returns_a_group_model_with_the_corresponding_id(){
        $group = factory(Group::class)->create(['id' => 2]);
        $groupRepo = new \BristolSU\ControlDB\Repositories\Group();
        $this->assertTrue(
            $group->is($groupRepo->getById(2))
        );
    }

    /** @test */
    public function getById_throws_a_modelNotFoundException_if_group_does_not_exist(){
        $this->expectException(ModelNotFoundException::class);
        $groupRepo = new \BristolSU\ControlDB\Repositories\Group();
        $groupRepo->getById(5);
    }

    /** @test */
    public function all_returns_all_groups(){
        $groups = factory(Group::class, 15)->create();
        $groupRepo = new \BristolSU\ControlDB\Repositories\Group();
        $repoGroups = $groupRepo->all();
        foreach($groups as $group) {
            $this->assertTrue($group->is(
                $repoGroups->shift()
            ));
        }
    }


}
