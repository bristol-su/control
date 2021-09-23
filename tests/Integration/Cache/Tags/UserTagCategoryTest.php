<?php

namespace BristolSU\Tests\ControlDB\Integration\Cache\Tags;

use BristolSU\ControlDB\Models\Tags\UserTag;
use BristolSU\ControlDB\Models\Tags\UserTagCategory;
use BristolSU\ControlDB\Repositories\Tags\UserTagCategory as UserTagCategoryRepository;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;
use Prophecy\Argument;

class UserTagCategoryTest extends TestCase
{

    /** @test */
    public function all_does_not_save_in_the_cache()
    {
        $userTagCategories = UserTagCategory::factory()->count(5)->create();

        $userTagCategoryRepository = $this->prophesize(UserTagCategoryRepository::class);
        $userTagCategoryRepository->all()->shouldBeCalled()->willReturn($userTagCategories);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $userTagCategoryCache = new \BristolSU\ControlDB\Cache\Tags\UserTagCategory($userTagCategoryRepository->reveal(), $cache->reveal());

        $this->assertCount(5, $userTagCategoryCache->all());
    }


    /** @test */
    public function create_does_not_save_in_the_cache()
    {
        $userTagCategory = UserTagCategory::factory()->create();

        $userTagCategoryRepository = $this->prophesize(UserTagCategoryRepository::class);
        $userTagCategoryRepository->create('name1', 'desc1', 'ref1')->shouldBeCalled()->willReturn($userTagCategory);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $userTagCategoryCache = new \BristolSU\ControlDB\Cache\Tags\UserTagCategory($userTagCategoryRepository->reveal(), $cache->reveal());

        $this->assertTrue($userTagCategory->is($userTagCategoryCache->create('name1', 'desc1', 'ref1')));
    }

    /** @test */
    public function update_does_not_save_in_the_cache()
    {
        $userTagCategory = UserTagCategory::factory()->create();

        $userTagCategoryRepository = $this->prophesize(UserTagCategoryRepository::class);
        $userTagCategoryRepository->update($userTagCategory->id(), 'name1', 'desc1', 'ref1')->shouldBeCalled()->willReturn($userTagCategory);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $userTagCategoryCache = new \BristolSU\ControlDB\Cache\Tags\UserTagCategory($userTagCategoryRepository->reveal(), $cache->reveal());

        $this->assertTrue($userTagCategory->is($userTagCategoryCache->update($userTagCategory->id(), 'name1', 'desc1', 'ref1')));
    }

    /** @test */
    public function delete_does_not_save_in_the_cache()
    {
        $userTagCategory = UserTagCategory::factory()->create();

        $userTagCategoryRepository = $this->prophesize(UserTagCategoryRepository::class);
        $userTagCategoryRepository->delete($userTagCategory->id())->shouldBeCalled();

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $userTagCategoryCache = new \BristolSU\ControlDB\Cache\Tags\UserTagCategory($userTagCategoryRepository->reveal(), $cache->reveal());

        $this->assertNull($userTagCategoryCache->delete($userTagCategory->id()));
    }

    /** @test */
    public function getById_saves_tags_in_the_cache(){
        $userTagCategory = UserTagCategory::factory()->create();

        $userTagCategoryRepository = $this->prophesize(UserTagCategoryRepository::class);
        $userTagCategoryRepository->getById($userTagCategory->id())->shouldBeCalled()->willReturn($userTagCategory);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Tags\UserTagCategory::class . '@getById:' . $userTagCategory->id();

        $userTagCategoryCache = new \BristolSU\ControlDB\Cache\Tags\UserTagCategory($userTagCategoryRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertTrue($userTagCategory->is($userTagCategoryCache->getById($userTagCategory->id())));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($userTagCategory->is($cache->get($key)));
    }

    /** @test */
    public function getByReference_saves_tags_in_the_cache(){
        $userTagCategory = UserTagCategory::factory()->create();

        $userTagCategoryRepository = $this->prophesize(UserTagCategoryRepository::class);
        $userTagCategoryRepository->getByReference('ref')->shouldBeCalled()->willReturn($userTagCategory);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Tags\UserTagCategory::class . '@getByReference:ref';

        $userTagCategoryCache = new \BristolSU\ControlDB\Cache\Tags\UserTagCategory($userTagCategoryRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertTrue($userTagCategory->is($userTagCategoryCache->getByReference('ref')));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($userTagCategory->is($cache->get($key)));
    }

}
