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

    /** @test */
    public function count_returns_the_number_of_groups(){
        $groups = factory(Group::class, 18)->create();
        $groupRepo = new \BristolSU\ControlDB\Repositories\Group();

        $this->assertEquals(18, $groupRepo->count());
    }

    /** @test */
    public function paginate_returns_the_number_of_groups_specified_for_the_given_page(){
        $groups = factory(Group::class, 40)->create();
        $groupRepo = new \BristolSU\ControlDB\Repositories\Group();

        $paginatedGroups = $groupRepo->paginate(2, 10);
        $this->assertEquals(10, $paginatedGroups->count());
        $this->assertTrue($groups[10]->is($paginatedGroups->shift()));
        $this->assertTrue($groups[11]->is($paginatedGroups->shift()));
        $this->assertTrue($groups[12]->is($paginatedGroups->shift()));
        $this->assertTrue($groups[13]->is($paginatedGroups->shift()));
        $this->assertTrue($groups[14]->is($paginatedGroups->shift()));
        $this->assertTrue($groups[15]->is($paginatedGroups->shift()));
        $this->assertTrue($groups[16]->is($paginatedGroups->shift()));
        $this->assertTrue($groups[17]->is($paginatedGroups->shift()));
        $this->assertTrue($groups[18]->is($paginatedGroups->shift()));
        $this->assertTrue($groups[19]->is($paginatedGroups->shift()));
    }

    /** @test */
    public function update_updates_a_group(){
        $dataGroup1 = factory(DataGroup::class)->create();
        $dataGroup2 = factory(DataGroup::class)->create();
        $group = factory(Group::class)->create(['data_provider_id' => $dataGroup1->id()]);

        $this->assertDatabaseHas('control_groups', [
            'id' => $group->id(), 'data_provider_id' => $dataGroup1->id()
        ]);

        $repository = new \BristolSU\ControlDB\Repositories\Group();
        $repository->update($group->id(), $dataGroup2->id());

        $this->assertDatabaseMissing('control_groups', [
            'id' => $group->id(), 'data_provider_id' => $dataGroup1->id()
        ]);
        $this->assertDatabaseHas('control_groups', [
            'id' => $group->id(), 'data_provider_id' => $dataGroup2->id()
        ]);
    }

    /** @test */
    public function update_returns_the_updated_group(){
        $dataGroup1 = factory(DataGroup::class)->create();
        $dataGroup2 = factory(DataGroup::class)->create();
        $group = factory(Group::class)->create(['data_provider_id' => $dataGroup1->id()]);

        $this->assertEquals($dataGroup1->id(), $group->dataProviderId());

        $repository = new \BristolSU\ControlDB\Repositories\Group();
        $updatedGroup = $repository->update($group->id(), $dataGroup2->id());

        $this->assertEquals($dataGroup2->id(), $updatedGroup->dataProviderId());
    }
    
}
