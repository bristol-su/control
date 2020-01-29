<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories;

use BristolSU\ControlDB\Models\DataGroup;
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
    public function create_creates_a_new_group_model(){
        $dataGroup = factory(DataGroup::class)->create();

        $groupRepo = new \BristolSU\ControlDB\Repositories\Group();
        $group = $groupRepo->create($dataGroup->id);

        $this->assertDatabaseHas('control_groups', [
            'data_provider_id' => $dataGroup->id
        ]);
    }

    /** @test */
    public function create_returns_the_new_group_model(){
        $dataGroup = factory(DataGroup::class)->create();

        $groupRepo = new \BristolSU\ControlDB\Repositories\Group();
        $group = $groupRepo->create($dataGroup->id);

        $this->assertInstanceOf(Group::class, $group);
        $this->assertEquals($dataGroup->id, $group->dataProviderId());
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

    /** @test */
    public function getByDataProviderId_returns_a_group_model_with_a_given_data_provider_id()
    {
        $dataGroup = factory(DataGroup::class)->create();
        $group = factory(Group::class)->create(['data_provider_id' => $dataGroup->id]);

        $groupRepo = new \BristolSU\ControlDB\Repositories\Group();
        $dbGroup = $groupRepo->getByDataProviderId($dataGroup->id);

        $this->assertInstanceOf(Group::class, $dbGroup);
        $this->assertEquals($dataGroup->id, $dbGroup->dataProviderId());
        $this->assertEquals($group->id, $dbGroup->dataProviderId());
    }

    /** @test */
    public function getByDataProviderId_throws_an_exception_if_no_model_found()
    {
        $this->expectException(ModelNotFoundException::class);
        factory(Group::class)->create(['data_provider_id' => 10]);

        $groupRepo = new \BristolSU\ControlDB\Repositories\Group();
        $groupRepo->getByDataProviderId(11);

    }

    /** @test */
    public function delete_deletes_a_group_model(){
        $group = factory(Group::class)->create();
        $groupRepo = new \BristolSU\ControlDB\Repositories\Group();
        $groupRepo->delete($group->id());

        $group->refresh();
        $this->assertTrue($group->trashed());
    }

}
