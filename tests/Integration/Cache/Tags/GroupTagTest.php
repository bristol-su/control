<?php

namespace BristolSU\Tests\ControlDB\Integration\Cache\Tags;

use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\ControlDB\Models\Tags\GroupTagCategory;
use BristolSU\ControlDB\Repositories\Tags\GroupTag as GroupTagRepository;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;
use Prophecy\Argument;

class GroupTagTest extends TestCase
{

    /** @test */
    public function all_does_not_save_in_the_cache()
    {
        $groupTags = factory(GroupTag::class, 5)->create();

        $groupTagRepository = $this->prophesize(GroupTagRepository::class);
        $groupTagRepository->all()->shouldBeCalled()->willReturn($groupTags);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $groupTagCache = new \BristolSU\ControlDB\Cache\Tags\GroupTag($groupTagRepository->reveal(), $cache->reveal());

        $this->assertCount(5, $groupTagCache->all());
    }


    /** @test */
    public function create_does_not_save_in_the_cache()
    {
        $groupTagCategory = factory(GroupTagCategory::class)->create();
        $groupTag = factory(GroupTag::class)->create(['tag_category_id' => $groupTagCategory->id()]);

        $groupTagRepository = $this->prophesize(GroupTagRepository::class);
        $groupTagRepository->create('name1', 'desc1', 'ref1', $groupTagCategory->id())->shouldBeCalled()->willReturn($groupTag);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $groupTagCache = new \BristolSU\ControlDB\Cache\Tags\GroupTag($groupTagRepository->reveal(), $cache->reveal());

        $this->assertTrue($groupTag->is($groupTagCache->create('name1', 'desc1', 'ref1', $groupTagCategory->id())));
    }

    /** @test */
    public function update_does_not_save_in_the_cache()
    {
        $groupTagCategory = factory(GroupTagCategory::class)->create();
        $groupTag = factory(GroupTag::class)->create(['tag_category_id' => $groupTagCategory->id()]);

        $groupTagRepository = $this->prophesize(GroupTagRepository::class);
        $groupTagRepository->update($groupTag->id(), 'name1', 'desc1', 'ref1', $groupTagCategory->id())->shouldBeCalled()->willReturn($groupTag);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $groupTagCache = new \BristolSU\ControlDB\Cache\Tags\GroupTag($groupTagRepository->reveal(), $cache->reveal());

        $this->assertTrue($groupTag->is($groupTagCache->update($groupTag->id(), 'name1', 'desc1', 'ref1', $groupTagCategory->id())));
    }

    /** @test */
    public function delete_does_not_save_in_the_cache()
    {
        $groupTagCategory = factory(GroupTagCategory::class)->create();
        $groupTag = factory(GroupTag::class)->create(['tag_category_id' => $groupTagCategory->id()]);

        $groupTagRepository = $this->prophesize(GroupTagRepository::class);
        $groupTagRepository->delete($groupTag->id())->shouldBeCalled();

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $groupTagCache = new \BristolSU\ControlDB\Cache\Tags\GroupTag($groupTagRepository->reveal(), $cache->reveal());

        $this->assertNull($groupTagCache->delete($groupTag->id()));
    }
    
    /** @test */
    public function allThroughTagCategory_saves_tags_in_the_cache(){
        $tagCategory = factory(GroupTagCategory::class)->create();
        $groupTags = factory(GroupTag::class, 5)->create(['tag_category_id' => $tagCategory->id()]);

        $groupTagRepository = $this->prophesize(GroupTagRepository::class);
        $groupTagRepository->allThroughTagCategory(Argument::that(function($arg) use ($tagCategory) {
            return $arg instanceof GroupTagCategory && $arg->is($tagCategory);
        }))->shouldBeCalled()->willReturn($groupTags);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Tags\GroupTag::class . '@allThroughTagCategory:' . $tagCategory->id();

        $groupTagCache = new \BristolSU\ControlDB\Cache\Tags\GroupTag($groupTagRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertCount(5, $groupTagCache->allThroughTagCategory($tagCategory));
        $this->assertTrue($cache->has($key));
        $this->assertInstanceOf(Collection::class, $cache->get($key));
        $this->assertContainsOnlyInstancesOf(GroupTag::class, $cache->get($key));
        $this->assertCount(5, $cache->get($key));
        
    }

    /** @test */
    public function getById_saves_tags_in_the_cache(){
        $groupTag = factory(GroupTag::class)->create();

        $groupTagRepository = $this->prophesize(GroupTagRepository::class);
        $groupTagRepository->getById($groupTag->id())->shouldBeCalled()->willReturn($groupTag);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Tags\GroupTag::class . '@getById:' . $groupTag->id();

        $groupTagCache = new \BristolSU\ControlDB\Cache\Tags\GroupTag($groupTagRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertTrue($groupTag->is($groupTagCache->getById($groupTag->id())));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($groupTag->is($cache->get($key)));
    }

    /** @test */
    public function getTagByFullReference_saves_tags_in_the_cache(){
        $groupTag = factory(GroupTag::class)->create();

        $groupTagRepository = $this->prophesize(GroupTagRepository::class);
        $groupTagRepository->getTagByFullReference('full.ref')->shouldBeCalled()->willReturn($groupTag);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Tags\GroupTag::class . '@getTagByFullReference:full.ref';

        $groupTagCache = new \BristolSU\ControlDB\Cache\Tags\GroupTag($groupTagRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertTrue($groupTag->is($groupTagCache->getTagByFullReference('full.ref')));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($groupTag->is($cache->get($key)));
    }

}