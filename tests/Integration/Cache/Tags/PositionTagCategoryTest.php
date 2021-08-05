<?php

namespace BristolSU\Tests\ControlDB\Integration\Cache\Tags;

use BristolSU\ControlDB\Models\Tags\PositionTag;
use BristolSU\ControlDB\Models\Tags\PositionTagCategory;
use BristolSU\ControlDB\Repositories\Tags\PositionTagCategory as PositionTagCategoryRepository;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;
use Prophecy\Argument;

class PositionTagCategoryTest extends TestCase
{

    /** @test */
    public function all_does_not_save_in_the_cache()
    {
        $positionTagCategories = PositionTagCategory::factory()->count(5)->create();

        $positionTagCategoryRepository = $this->prophesize(PositionTagCategoryRepository::class);
        $positionTagCategoryRepository->all()->shouldBeCalled()->willReturn($positionTagCategories);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $positionTagCategoryCache = new \BristolSU\ControlDB\Cache\Tags\PositionTagCategory($positionTagCategoryRepository->reveal(), $cache->reveal());

        $this->assertCount(5, $positionTagCategoryCache->all());
    }


    /** @test */
    public function create_does_not_save_in_the_cache()
    {
        $positionTagCategory = PositionTagCategory::factory()->create();

        $positionTagCategoryRepository = $this->prophesize(PositionTagCategoryRepository::class);
        $positionTagCategoryRepository->create('name1', 'desc1', 'ref1')->shouldBeCalled()->willReturn($positionTagCategory);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $positionTagCategoryCache = new \BristolSU\ControlDB\Cache\Tags\PositionTagCategory($positionTagCategoryRepository->reveal(), $cache->reveal());

        $this->assertTrue($positionTagCategory->is($positionTagCategoryCache->create('name1', 'desc1', 'ref1')));
    }

    /** @test */
    public function update_does_not_save_in_the_cache()
    {
        $positionTagCategory = PositionTagCategory::factory()->create();

        $positionTagCategoryRepository = $this->prophesize(PositionTagCategoryRepository::class);
        $positionTagCategoryRepository->update($positionTagCategory->id(), 'name1', 'desc1', 'ref1')->shouldBeCalled()->willReturn($positionTagCategory);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $positionTagCategoryCache = new \BristolSU\ControlDB\Cache\Tags\PositionTagCategory($positionTagCategoryRepository->reveal(), $cache->reveal());

        $this->assertTrue($positionTagCategory->is($positionTagCategoryCache->update($positionTagCategory->id(), 'name1', 'desc1', 'ref1')));
    }

    /** @test */
    public function delete_does_not_save_in_the_cache()
    {
        $positionTagCategory = PositionTagCategory::factory()->create();

        $positionTagCategoryRepository = $this->prophesize(PositionTagCategoryRepository::class);
        $positionTagCategoryRepository->delete($positionTagCategory->id())->shouldBeCalled();

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $positionTagCategoryCache = new \BristolSU\ControlDB\Cache\Tags\PositionTagCategory($positionTagCategoryRepository->reveal(), $cache->reveal());

        $this->assertNull($positionTagCategoryCache->delete($positionTagCategory->id()));
    }

    /** @test */
    public function getById_saves_tags_in_the_cache(){
        $positionTagCategory = PositionTagCategory::factory()->create();

        $positionTagCategoryRepository = $this->prophesize(PositionTagCategoryRepository::class);
        $positionTagCategoryRepository->getById($positionTagCategory->id())->shouldBeCalled()->willReturn($positionTagCategory);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Tags\PositionTagCategory::class . '@getById:' . $positionTagCategory->id();

        $positionTagCategoryCache = new \BristolSU\ControlDB\Cache\Tags\PositionTagCategory($positionTagCategoryRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertTrue($positionTagCategory->is($positionTagCategoryCache->getById($positionTagCategory->id())));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($positionTagCategory->is($cache->get($key)));
    }

    /** @test */
    public function getByReference_saves_tags_in_the_cache(){
        $positionTagCategory = PositionTagCategory::factory()->create();

        $positionTagCategoryRepository = $this->prophesize(PositionTagCategoryRepository::class);
        $positionTagCategoryRepository->getByReference('ref')->shouldBeCalled()->willReturn($positionTagCategory);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Tags\PositionTagCategory::class . '@getByReference:ref';

        $positionTagCategoryCache = new \BristolSU\ControlDB\Cache\Tags\PositionTagCategory($positionTagCategoryRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertTrue($positionTagCategory->is($positionTagCategoryCache->getByReference('ref')));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($positionTagCategory->is($cache->get($key)));
    }

}
