<?php

namespace BristolSU\Tests\ControlDB\Integration\Cache;

use BristolSU\ControlDB\Contracts\Repositories\Group as GroupRepository;
use BristolSU\ControlDB\Models\DataGroup;
use BristolSU\ControlDB\Models\Group;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Contracts\Cache\Repository;
use Prophecy\Argument;

class GroupTest extends TestCase
{

    /** @test */
    public function getById_saves_the_group_in_the_cache(){
        $group = Group::factory()->create();

        $groupRepository = $this->prophesize(GroupRepository::class);
        $groupRepository->getById($group->id())->shouldBeCalled()->willReturn($group);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Group::class . '@getById:' . $group->id();

        $groupCache = new \BristolSU\ControlDB\Cache\Group($groupRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertTrue($group->is($groupCache->getById($group->id())));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($group->is($cache->get($key)));
    }

    /** @test */
    public function getByDataProviderId_saves_the_group_in_the_cache(){
        $dataProvider = DataGroup::factory()->create();
        $group = Group::factory()->create(['data_provider_id' => $dataProvider->id()]);

        $groupRepository = $this->prophesize(GroupRepository::class);
        $groupRepository->getByDataProviderId($group->id())->shouldBeCalled()->willReturn($group);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Group::class . '@getByDataProviderId:' . $dataProvider->id();

        $groupCache = new \BristolSU\ControlDB\Cache\Group($groupRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertTrue($group->is($groupCache->getByDataProviderId($dataProvider->id())));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($group->is($cache->get($key)));
    }

    /** @test */
    public function all_does_not_save_in_the_cache()
    {
        $groups = Group::factory()->count(5)->create();

        $groupRepository = $this->prophesize(GroupRepository::class);
        $groupRepository->all()->shouldBeCalled()->willReturn($groups);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $groupCache = new \BristolSU\ControlDB\Cache\Group($groupRepository->reveal(), $cache->reveal());

        $this->assertCount(5, $groupCache->all());
    }

    /** @test */
    public function create_does_not_save_in_the_cache()
    {
        $dataProvider = DataGroup::factory()->create();
        $group = Group::factory()->create(['data_provider_id' => $dataProvider->id()]);

        $groupRepository = $this->prophesize(GroupRepository::class);
        $groupRepository->create($dataProvider->id())->shouldBeCalled()->willReturn($group);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $groupCache = new \BristolSU\ControlDB\Cache\Group($groupRepository->reveal(), $cache->reveal());

        $this->assertTrue($group->is($groupCache->create($dataProvider->id())));
    }

    /** @test */
    public function delete_does_not_save_in_the_cache()
    {
        $group = Group::factory()->create();

        $groupRepository = $this->prophesize(GroupRepository::class);
        $groupRepository->delete($group->id())->shouldBeCalled();

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $groupCache = new \BristolSU\ControlDB\Cache\Group($groupRepository->reveal(), $cache->reveal());

        $this->assertNull($groupCache->delete($group->id()));
    }

    /** @test */
    public function paginate_does_not_save_in_the_cache()
    {
        $groups = Group::factory()->count(5)->create();

        $groupRepository = $this->prophesize(GroupRepository::class);
        $groupRepository->paginate(1, 2)->shouldBeCalled()->willReturn($groups);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $groupCache = new \BristolSU\ControlDB\Cache\Group($groupRepository->reveal(), $cache->reveal());

        $this->assertCount(5, $groupCache->paginate(1,  2));
    }

    /** @test */
    public function update_does_not_save_in_the_cache()
    {
        $dataProvider = DataGroup::factory()->create();
        $group = Group::factory()->create(['data_provider_id' => $dataProvider->id()]);

        $groupRepository = $this->prophesize(GroupRepository::class);
        $groupRepository->update($group->id(), $dataProvider->id())->shouldBeCalled()->willReturn($group);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $groupCache = new \BristolSU\ControlDB\Cache\Group($groupRepository->reveal(), $cache->reveal());

        $this->assertTrue($group->is($groupCache->update($group->id(), $dataProvider->id())));
    }

    /** @test */
    public function count_saves_the_count_in_the_cache(){
        $groupRepository = $this->prophesize(GroupRepository::class);
        $groupRepository->count()->shouldBeCalled()->willReturn(19);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Group::class . '@count';

        $groupCache = new \BristolSU\ControlDB\Cache\Group($groupRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertEquals(19, $groupCache->count());
        $this->assertTrue($cache->has($key));
        $this->assertEquals(19, $cache->get($key));
    }

}
