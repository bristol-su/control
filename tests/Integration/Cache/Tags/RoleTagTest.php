<?php

namespace BristolSU\Tests\ControlDB\Integration\Cache\Tags;

use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\ControlDB\Models\Tags\RoleTagCategory;
use BristolSU\ControlDB\Repositories\Tags\RoleTag as RoleTagRepository;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;
use Prophecy\Argument;

class RoleTagTest extends TestCase
{

    /** @test */
    public function all_does_not_save_in_the_cache()
    {
        $roleTags = factory(RoleTag::class, 5)->create();

        $roleTagRepository = $this->prophesize(RoleTagRepository::class);
        $roleTagRepository->all()->shouldBeCalled()->willReturn($roleTags);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $roleTagCache = new \BristolSU\ControlDB\Cache\Tags\RoleTag($roleTagRepository->reveal(), $cache->reveal());

        $this->assertCount(5, $roleTagCache->all());
    }


    /** @test */
    public function create_does_not_save_in_the_cache()
    {
        $roleTagCategory = factory(RoleTagCategory::class)->create();
        $roleTag = factory(RoleTag::class)->create(['tag_category_id' => $roleTagCategory->id()]);

        $roleTagRepository = $this->prophesize(RoleTagRepository::class);
        $roleTagRepository->create('name1', 'desc1', 'ref1', $roleTagCategory->id())->shouldBeCalled()->willReturn($roleTag);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $roleTagCache = new \BristolSU\ControlDB\Cache\Tags\RoleTag($roleTagRepository->reveal(), $cache->reveal());

        $this->assertTrue($roleTag->is($roleTagCache->create('name1', 'desc1', 'ref1', $roleTagCategory->id())));
    }

    /** @test */
    public function update_does_not_save_in_the_cache()
    {
        $roleTagCategory = factory(RoleTagCategory::class)->create();
        $roleTag = factory(RoleTag::class)->create(['tag_category_id' => $roleTagCategory->id()]);

        $roleTagRepository = $this->prophesize(RoleTagRepository::class);
        $roleTagRepository->update($roleTag->id(), 'name1', 'desc1', 'ref1', $roleTagCategory->id())->shouldBeCalled()->willReturn($roleTag);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $roleTagCache = new \BristolSU\ControlDB\Cache\Tags\RoleTag($roleTagRepository->reveal(), $cache->reveal());

        $this->assertTrue($roleTag->is($roleTagCache->update($roleTag->id(), 'name1', 'desc1', 'ref1', $roleTagCategory->id())));
    }

    /** @test */
    public function delete_does_not_save_in_the_cache()
    {
        $roleTagCategory = factory(RoleTagCategory::class)->create();
        $roleTag = factory(RoleTag::class)->create(['tag_category_id' => $roleTagCategory->id()]);

        $roleTagRepository = $this->prophesize(RoleTagRepository::class);
        $roleTagRepository->delete($roleTag->id())->shouldBeCalled();

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $roleTagCache = new \BristolSU\ControlDB\Cache\Tags\RoleTag($roleTagRepository->reveal(), $cache->reveal());

        $this->assertNull($roleTagCache->delete($roleTag->id()));
    }
    
    /** @test */
    public function allThroughTagCategory_saves_tags_in_the_cache(){
        $tagCategory = factory(RoleTagCategory::class)->create();
        $roleTags = factory(RoleTag::class, 5)->create(['tag_category_id' => $tagCategory->id()]);

        $roleTagRepository = $this->prophesize(RoleTagRepository::class);
        $roleTagRepository->allThroughTagCategory(Argument::that(function($arg) use ($tagCategory) {
            return $arg instanceof RoleTagCategory && $arg->is($tagCategory);
        }))->shouldBeCalled()->willReturn($roleTags);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Tags\RoleTag::class . '@allThroughTagCategory:' . $tagCategory->id();

        $roleTagCache = new \BristolSU\ControlDB\Cache\Tags\RoleTag($roleTagRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertCount(5, $roleTagCache->allThroughTagCategory($tagCategory));
        $this->assertTrue($cache->has($key));
        $this->assertInstanceOf(Collection::class, $cache->get($key));
        $this->assertContainsOnlyInstancesOf(RoleTag::class, $cache->get($key));
        $this->assertCount(5, $cache->get($key));
        
    }

    /** @test */
    public function getById_saves_tags_in_the_cache(){
        $roleTag = factory(RoleTag::class)->create();

        $roleTagRepository = $this->prophesize(RoleTagRepository::class);
        $roleTagRepository->getById($roleTag->id())->shouldBeCalled()->willReturn($roleTag);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Tags\RoleTag::class . '@getById:' . $roleTag->id();

        $roleTagCache = new \BristolSU\ControlDB\Cache\Tags\RoleTag($roleTagRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertTrue($roleTag->is($roleTagCache->getById($roleTag->id())));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($roleTag->is($cache->get($key)));
    }

    /** @test */
    public function getTagByFullReference_saves_tags_in_the_cache(){
        $roleTag = factory(RoleTag::class)->create();

        $roleTagRepository = $this->prophesize(RoleTagRepository::class);
        $roleTagRepository->getTagByFullReference('full.ref')->shouldBeCalled()->willReturn($roleTag);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Tags\RoleTag::class . '@getTagByFullReference:full.ref';

        $roleTagCache = new \BristolSU\ControlDB\Cache\Tags\RoleTag($roleTagRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertTrue($roleTag->is($roleTagCache->getTagByFullReference('full.ref')));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($roleTag->is($cache->get($key)));
    }

}