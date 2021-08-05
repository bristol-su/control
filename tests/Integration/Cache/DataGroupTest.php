<?php

namespace BristolSU\Tests\ControlDB\Integration\Cache;

use BristolSU\ControlDB\Models\DataGroup;
use BristolSU\ControlDB\Repositories\DataGroup as DataGroupRepository;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Contracts\Cache\Repository;
use Prophecy\Argument;

class DataGroupTest extends TestCase
{

    /** @test */
    public function getById_saves_the_group_in_the_cache(){
        $dataGroup = DataGroup::factory()->create();

        $groupRepository = $this->prophesize(DataGroupRepository::class);
        $groupRepository->getById($dataGroup->id())->shouldBeCalled()->willReturn($dataGroup);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\DataGroup::class . '@getById:' . $dataGroup->id();

        $groupCache = new \BristolSU\ControlDB\Cache\DataGroup($groupRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertTrue($dataGroup->is($groupCache->getById($dataGroup->id())));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($dataGroup->is($cache->get($key)));
    }

    /** @test */
    public function getWhere_does_not_save_in_the_cache()
    {
        $group = DataGroup::factory()->create();

        $groupRepository = $this->prophesize(DataGroupRepository::class);
        $groupRepository->getWhere(['email' => 'test@test.com'])->shouldBeCalled()->willReturn($group);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $groupCache = new \BristolSU\ControlDB\Cache\DataGroup($groupRepository->reveal(), $cache->reveal());

        $this->assertTrue($group->is($groupCache->getWhere(['email' => 'test@test.com'])));
    }

    /** @test */
    public function getAllWhere_does_not_save_in_the_cache()
    {
        $groups = DataGroup::factory()->count(5)->create();

        $groupRepository = $this->prophesize(DataGroupRepository::class);
        $groupRepository->getAllWhere(['email' => 'test@test.com'])->shouldBeCalled()->willReturn($groups);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $groupCache = new \BristolSU\ControlDB\Cache\DataGroup($groupRepository->reveal(), $cache->reveal());

        $this->assertCount(5, $groupCache->getAllWhere(['email' => 'test@test.com']));
    }

    /** @test */
    public function update_does_not_save_in_the_cache()
    {
        $group = DataGroup::factory()->create();

        $groupRepository = $this->prophesize(DataGroupRepository::class);
        $groupRepository->update($group->id(), 'N', 'E')->shouldBeCalled()->willReturn($group);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $groupCache = new \BristolSU\ControlDB\Cache\DataGroup($groupRepository->reveal(), $cache->reveal());

        $this->assertTrue($group->is($groupCache->update($group->id(), 'N', 'E')));
    }

    /** @test */
    public function create_does_not_save_in_the_cache()
    {
        $group = DataGroup::factory()->create();

        $groupRepository = $this->prophesize(DataGroupRepository::class);
        $groupRepository->create('N', 'E')->shouldBeCalled()->willReturn($group);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $groupCache = new \BristolSU\ControlDB\Cache\DataGroup($groupRepository->reveal(), $cache->reveal());

        $this->assertTrue($group->is($groupCache->create('N', 'E')));
    }


}
