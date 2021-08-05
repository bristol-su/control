<?php

namespace BristolSU\Tests\ControlDB\Integration\Cache\Tags;

use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\ControlDB\Models\Tags\GroupTagCategory;
use BristolSU\ControlDB\Repositories\Tags\GroupTagCategory as GroupTagCategoryRepository;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;
use Prophecy\Argument;

class GroupTagCategoryTest extends TestCase
{

    /** @test */
    public function all_does_not_save_in_the_cache()
    {
        $groupTagCategories = GroupTagCategory::factory()->count(5)->create();

        $groupTagCategoryRepository = $this->prophesize(GroupTagCategoryRepository::class);
        $groupTagCategoryRepository->all()->shouldBeCalled()->willReturn($groupTagCategories);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $groupTagCategoryCache = new \BristolSU\ControlDB\Cache\Tags\GroupTagCategory($groupTagCategoryRepository->reveal(), $cache->reveal());

        $this->assertCount(5, $groupTagCategoryCache->all());
    }


    /** @test */
    public function create_does_not_save_in_the_cache()
    {
        $groupTagCategory = GroupTagCategory::factory()->create();

        $groupTagCategoryRepository = $this->prophesize(GroupTagCategoryRepository::class);
        $groupTagCategoryRepository->create('name1', 'desc1', 'ref1')->shouldBeCalled()->willReturn($groupTagCategory);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $groupTagCategoryCache = new \BristolSU\ControlDB\Cache\Tags\GroupTagCategory($groupTagCategoryRepository->reveal(), $cache->reveal());

        $this->assertTrue($groupTagCategory->is($groupTagCategoryCache->create('name1', 'desc1', 'ref1')));
    }

    /** @test */
    public function update_does_not_save_in_the_cache()
    {
        $groupTagCategory = GroupTagCategory::factory()->create();

        $groupTagCategoryRepository = $this->prophesize(GroupTagCategoryRepository::class);
        $groupTagCategoryRepository->update($groupTagCategory->id(), 'name1', 'desc1', 'ref1')->shouldBeCalled()->willReturn($groupTagCategory);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $groupTagCategoryCache = new \BristolSU\ControlDB\Cache\Tags\GroupTagCategory($groupTagCategoryRepository->reveal(), $cache->reveal());

        $this->assertTrue($groupTagCategory->is($groupTagCategoryCache->update($groupTagCategory->id(), 'name1', 'desc1', 'ref1')));
    }

    /** @test */
    public function delete_does_not_save_in_the_cache()
    {
        $groupTagCategory = GroupTagCategory::factory()->create();

        $groupTagCategoryRepository = $this->prophesize(GroupTagCategoryRepository::class);
        $groupTagCategoryRepository->delete($groupTagCategory->id())->shouldBeCalled();

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $groupTagCategoryCache = new \BristolSU\ControlDB\Cache\Tags\GroupTagCategory($groupTagCategoryRepository->reveal(), $cache->reveal());

        $this->assertNull($groupTagCategoryCache->delete($groupTagCategory->id()));
    }

    /** @test */
    public function getById_saves_tags_in_the_cache(){
        $groupTagCategory = GroupTagCategory::factory()->create();

        $groupTagCategoryRepository = $this->prophesize(GroupTagCategoryRepository::class);
        $groupTagCategoryRepository->getById($groupTagCategory->id())->shouldBeCalled()->willReturn($groupTagCategory);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Tags\GroupTagCategory::class . '@getById:' . $groupTagCategory->id();

        $groupTagCategoryCache = new \BristolSU\ControlDB\Cache\Tags\GroupTagCategory($groupTagCategoryRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertTrue($groupTagCategory->is($groupTagCategoryCache->getById($groupTagCategory->id())));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($groupTagCategory->is($cache->get($key)));
    }

    /** @test */
    public function getByReference_saves_tags_in_the_cache(){
        $groupTagCategory = GroupTagCategory::factory()->create();

        $groupTagCategoryRepository = $this->prophesize(GroupTagCategoryRepository::class);
        $groupTagCategoryRepository->getByReference('ref')->shouldBeCalled()->willReturn($groupTagCategory);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Tags\GroupTagCategory::class . '@getByReference:ref';

        $groupTagCategoryCache = new \BristolSU\ControlDB\Cache\Tags\GroupTagCategory($groupTagCategoryRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertTrue($groupTagCategory->is($groupTagCategoryCache->getByReference('ref')));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($groupTagCategory->is($cache->get($key)));
    }

}
