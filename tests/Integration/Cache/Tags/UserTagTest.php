<?php

namespace BristolSU\Tests\ControlDB\Integration\Cache\Tags;

use BristolSU\ControlDB\Models\Tags\UserTag;
use BristolSU\ControlDB\Models\Tags\UserTagCategory;
use BristolSU\ControlDB\Repositories\Tags\UserTag as UserTagRepository;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;
use Prophecy\Argument;

class UserTagTest extends TestCase
{

    /** @test */
    public function all_does_not_save_in_the_cache()
    {
        $userTags = UserTag::factory()->count(5)->create();

        $userTagRepository = $this->prophesize(UserTagRepository::class);
        $userTagRepository->all()->shouldBeCalled()->willReturn($userTags);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $userTagCache = new \BristolSU\ControlDB\Cache\Tags\UserTag($userTagRepository->reveal(), $cache->reveal());

        $this->assertCount(5, $userTagCache->all());
    }


    /** @test */
    public function create_does_not_save_in_the_cache()
    {
        $userTagCategory = UserTagCategory::factory()->create();
        $userTag = UserTag::factory()->create(['tag_category_id' => $userTagCategory->id()]);

        $userTagRepository = $this->prophesize(UserTagRepository::class);
        $userTagRepository->create('name1', 'desc1', 'ref1', $userTagCategory->id())->shouldBeCalled()->willReturn($userTag);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $userTagCache = new \BristolSU\ControlDB\Cache\Tags\UserTag($userTagRepository->reveal(), $cache->reveal());

        $this->assertTrue($userTag->is($userTagCache->create('name1', 'desc1', 'ref1', $userTagCategory->id())));
    }

    /** @test */
    public function update_does_not_save_in_the_cache()
    {
        $userTagCategory = UserTagCategory::factory()->create();
        $userTag = UserTag::factory()->create(['tag_category_id' => $userTagCategory->id()]);

        $userTagRepository = $this->prophesize(UserTagRepository::class);
        $userTagRepository->update($userTag->id(), 'name1', 'desc1', 'ref1', $userTagCategory->id())->shouldBeCalled()->willReturn($userTag);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $userTagCache = new \BristolSU\ControlDB\Cache\Tags\UserTag($userTagRepository->reveal(), $cache->reveal());

        $this->assertTrue($userTag->is($userTagCache->update($userTag->id(), 'name1', 'desc1', 'ref1', $userTagCategory->id())));
    }

    /** @test */
    public function delete_does_not_save_in_the_cache()
    {
        $userTagCategory = UserTagCategory::factory()->create();
        $userTag = UserTag::factory()->create(['tag_category_id' => $userTagCategory->id()]);

        $userTagRepository = $this->prophesize(UserTagRepository::class);
        $userTagRepository->delete($userTag->id())->shouldBeCalled();

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $userTagCache = new \BristolSU\ControlDB\Cache\Tags\UserTag($userTagRepository->reveal(), $cache->reveal());

        $this->assertNull($userTagCache->delete($userTag->id()));
    }

    /** @test */
    public function allThroughTagCategory_saves_tags_in_the_cache(){
        $tagCategory = UserTagCategory::factory()->create();
        $userTags = UserTag::factory()->count(5)->create(['tag_category_id' => $tagCategory->id()]);

        $userTagRepository = $this->prophesize(UserTagRepository::class);
        $userTagRepository->allThroughTagCategory(Argument::that(function($arg) use ($tagCategory) {
            return $arg instanceof UserTagCategory && $arg->is($tagCategory);
        }))->shouldBeCalled()->willReturn($userTags);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Tags\UserTag::class . '@allThroughTagCategory:' . $tagCategory->id();

        $userTagCache = new \BristolSU\ControlDB\Cache\Tags\UserTag($userTagRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertCount(5, $userTagCache->allThroughTagCategory($tagCategory));
        $this->assertTrue($cache->has($key));
        $this->assertInstanceOf(Collection::class, $cache->get($key));
        $this->assertContainsOnlyInstancesOf(UserTag::class, $cache->get($key));
        $this->assertCount(5, $cache->get($key));

    }

    /** @test */
    public function getById_saves_tags_in_the_cache(){
        $userTag = UserTag::factory()->create();

        $userTagRepository = $this->prophesize(UserTagRepository::class);
        $userTagRepository->getById($userTag->id())->shouldBeCalled()->willReturn($userTag);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Tags\UserTag::class . '@getById:' . $userTag->id();

        $userTagCache = new \BristolSU\ControlDB\Cache\Tags\UserTag($userTagRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertTrue($userTag->is($userTagCache->getById($userTag->id())));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($userTag->is($cache->get($key)));
    }

    /** @test */
    public function getTagByFullReference_saves_tags_in_the_cache(){
        $userTag = UserTag::factory()->create();

        $userTagRepository = $this->prophesize(UserTagRepository::class);
        $userTagRepository->getTagByFullReference('full.ref')->shouldBeCalled()->willReturn($userTag);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Tags\UserTag::class . '@getTagByFullReference:full.ref';

        $userTagCache = new \BristolSU\ControlDB\Cache\Tags\UserTag($userTagRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertTrue($userTag->is($userTagCache->getTagByFullReference('full.ref')));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($userTag->is($cache->get($key)));
    }

}
