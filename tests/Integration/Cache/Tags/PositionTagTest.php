<?php

namespace BristolSU\Tests\ControlDB\Integration\Cache\Tags;

use BristolSU\ControlDB\Models\Tags\PositionTag;
use BristolSU\ControlDB\Models\Tags\PositionTagCategory;
use BristolSU\ControlDB\Repositories\Tags\PositionTag as PositionTagRepository;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;
use Prophecy\Argument;

class PositionTagTest extends TestCase
{

    /** @test */
    public function all_does_not_save_in_the_cache()
    {
        $positionTags = factory(PositionTag::class, 5)->create();

        $positionTagRepository = $this->prophesize(PositionTagRepository::class);
        $positionTagRepository->all()->shouldBeCalled()->willReturn($positionTags);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $positionTagCache = new \BristolSU\ControlDB\Cache\Tags\PositionTag($positionTagRepository->reveal(), $cache->reveal());

        $this->assertCount(5, $positionTagCache->all());
    }


    /** @test */
    public function create_does_not_save_in_the_cache()
    {
        $positionTagCategory = factory(PositionTagCategory::class)->create();
        $positionTag = factory(PositionTag::class)->create(['tag_category_id' => $positionTagCategory->id()]);

        $positionTagRepository = $this->prophesize(PositionTagRepository::class);
        $positionTagRepository->create('name1', 'desc1', 'ref1', $positionTagCategory->id())->shouldBeCalled()->willReturn($positionTag);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $positionTagCache = new \BristolSU\ControlDB\Cache\Tags\PositionTag($positionTagRepository->reveal(), $cache->reveal());

        $this->assertTrue($positionTag->is($positionTagCache->create('name1', 'desc1', 'ref1', $positionTagCategory->id())));
    }

    /** @test */
    public function update_does_not_save_in_the_cache()
    {
        $positionTagCategory = factory(PositionTagCategory::class)->create();
        $positionTag = factory(PositionTag::class)->create(['tag_category_id' => $positionTagCategory->id()]);

        $positionTagRepository = $this->prophesize(PositionTagRepository::class);
        $positionTagRepository->update($positionTag->id(), 'name1', 'desc1', 'ref1', $positionTagCategory->id())->shouldBeCalled()->willReturn($positionTag);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $positionTagCache = new \BristolSU\ControlDB\Cache\Tags\PositionTag($positionTagRepository->reveal(), $cache->reveal());

        $this->assertTrue($positionTag->is($positionTagCache->update($positionTag->id(), 'name1', 'desc1', 'ref1', $positionTagCategory->id())));
    }

    /** @test */
    public function delete_does_not_save_in_the_cache()
    {
        $positionTagCategory = factory(PositionTagCategory::class)->create();
        $positionTag = factory(PositionTag::class)->create(['tag_category_id' => $positionTagCategory->id()]);

        $positionTagRepository = $this->prophesize(PositionTagRepository::class);
        $positionTagRepository->delete($positionTag->id())->shouldBeCalled();

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $positionTagCache = new \BristolSU\ControlDB\Cache\Tags\PositionTag($positionTagRepository->reveal(), $cache->reveal());

        $this->assertNull($positionTagCache->delete($positionTag->id()));
    }
    
    /** @test */
    public function allThroughTagCategory_saves_tags_in_the_cache(){
        $tagCategory = factory(PositionTagCategory::class)->create();
        $positionTags = factory(PositionTag::class, 5)->create(['tag_category_id' => $tagCategory->id()]);

        $positionTagRepository = $this->prophesize(PositionTagRepository::class);
        $positionTagRepository->allThroughTagCategory(Argument::that(function($arg) use ($tagCategory) {
            return $arg instanceof PositionTagCategory && $arg->is($tagCategory);
        }))->shouldBeCalled()->willReturn($positionTags);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Tags\PositionTag::class . '@allThroughTagCategory:' . $tagCategory->id();

        $positionTagCache = new \BristolSU\ControlDB\Cache\Tags\PositionTag($positionTagRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertCount(5, $positionTagCache->allThroughTagCategory($tagCategory));
        $this->assertTrue($cache->has($key));
        $this->assertInstanceOf(Collection::class, $cache->get($key));
        $this->assertContainsOnlyInstancesOf(PositionTag::class, $cache->get($key));
        $this->assertCount(5, $cache->get($key));
        
    }

    /** @test */
    public function getById_saves_tags_in_the_cache(){
        $positionTag = factory(PositionTag::class)->create();

        $positionTagRepository = $this->prophesize(PositionTagRepository::class);
        $positionTagRepository->getById($positionTag->id())->shouldBeCalled()->willReturn($positionTag);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Tags\PositionTag::class . '@getById:' . $positionTag->id();

        $positionTagCache = new \BristolSU\ControlDB\Cache\Tags\PositionTag($positionTagRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertTrue($positionTag->is($positionTagCache->getById($positionTag->id())));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($positionTag->is($cache->get($key)));
    }

    /** @test */
    public function getTagByFullReference_saves_tags_in_the_cache(){
        $positionTag = factory(PositionTag::class)->create();

        $positionTagRepository = $this->prophesize(PositionTagRepository::class);
        $positionTagRepository->getTagByFullReference('full.ref')->shouldBeCalled()->willReturn($positionTag);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Tags\PositionTag::class . '@getTagByFullReference:full.ref';

        $positionTagCache = new \BristolSU\ControlDB\Cache\Tags\PositionTag($positionTagRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertTrue($positionTag->is($positionTagCache->getTagByFullReference('full.ref')));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($positionTag->is($cache->get($key)));
    }

}