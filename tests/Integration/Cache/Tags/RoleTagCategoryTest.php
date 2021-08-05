<?php

namespace BristolSU\Tests\ControlDB\Integration\Cache\Tags;

use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\ControlDB\Models\Tags\RoleTagCategory;
use BristolSU\ControlDB\Repositories\Tags\RoleTagCategory as RoleTagCategoryRepository;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;
use Prophecy\Argument;

class RoleTagCategoryTest extends TestCase
{

    /** @test */
    public function all_does_not_save_in_the_cache()
    {
        $roleTagCategories = RoleTagCategory::factory()->count(5)->create();

        $roleTagCategoryRepository = $this->prophesize(RoleTagCategoryRepository::class);
        $roleTagCategoryRepository->all()->shouldBeCalled()->willReturn($roleTagCategories);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $roleTagCategoryCache = new \BristolSU\ControlDB\Cache\Tags\RoleTagCategory($roleTagCategoryRepository->reveal(), $cache->reveal());

        $this->assertCount(5, $roleTagCategoryCache->all());
    }


    /** @test */
    public function create_does_not_save_in_the_cache()
    {
        $roleTagCategory = RoleTagCategory::factory()->create();

        $roleTagCategoryRepository = $this->prophesize(RoleTagCategoryRepository::class);
        $roleTagCategoryRepository->create('name1', 'desc1', 'ref1')->shouldBeCalled()->willReturn($roleTagCategory);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $roleTagCategoryCache = new \BristolSU\ControlDB\Cache\Tags\RoleTagCategory($roleTagCategoryRepository->reveal(), $cache->reveal());

        $this->assertTrue($roleTagCategory->is($roleTagCategoryCache->create('name1', 'desc1', 'ref1')));
    }

    /** @test */
    public function update_does_not_save_in_the_cache()
    {
        $roleTagCategory = RoleTagCategory::factory()->create();

        $roleTagCategoryRepository = $this->prophesize(RoleTagCategoryRepository::class);
        $roleTagCategoryRepository->update($roleTagCategory->id(), 'name1', 'desc1', 'ref1')->shouldBeCalled()->willReturn($roleTagCategory);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $roleTagCategoryCache = new \BristolSU\ControlDB\Cache\Tags\RoleTagCategory($roleTagCategoryRepository->reveal(), $cache->reveal());

        $this->assertTrue($roleTagCategory->is($roleTagCategoryCache->update($roleTagCategory->id(), 'name1', 'desc1', 'ref1')));
    }

    /** @test */
    public function delete_does_not_save_in_the_cache()
    {
        $roleTagCategory = RoleTagCategory::factory()->create();

        $roleTagCategoryRepository = $this->prophesize(RoleTagCategoryRepository::class);
        $roleTagCategoryRepository->delete($roleTagCategory->id())->shouldBeCalled();

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $roleTagCategoryCache = new \BristolSU\ControlDB\Cache\Tags\RoleTagCategory($roleTagCategoryRepository->reveal(), $cache->reveal());

        $this->assertNull($roleTagCategoryCache->delete($roleTagCategory->id()));
    }

    /** @test */
    public function getById_saves_tags_in_the_cache(){
        $roleTagCategory = RoleTagCategory::factory()->create();

        $roleTagCategoryRepository = $this->prophesize(RoleTagCategoryRepository::class);
        $roleTagCategoryRepository->getById($roleTagCategory->id())->shouldBeCalled()->willReturn($roleTagCategory);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Tags\RoleTagCategory::class . '@getById:' . $roleTagCategory->id();

        $roleTagCategoryCache = new \BristolSU\ControlDB\Cache\Tags\RoleTagCategory($roleTagCategoryRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertTrue($roleTagCategory->is($roleTagCategoryCache->getById($roleTagCategory->id())));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($roleTagCategory->is($cache->get($key)));
    }

    /** @test */
    public function getByReference_saves_tags_in_the_cache(){
        $roleTagCategory = RoleTagCategory::factory()->create();

        $roleTagCategoryRepository = $this->prophesize(RoleTagCategoryRepository::class);
        $roleTagCategoryRepository->getByReference('ref')->shouldBeCalled()->willReturn($roleTagCategory);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Tags\RoleTagCategory::class . '@getByReference:ref';

        $roleTagCategoryCache = new \BristolSU\ControlDB\Cache\Tags\RoleTagCategory($roleTagCategoryRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertTrue($roleTagCategory->is($roleTagCategoryCache->getByReference('ref')));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($roleTagCategory->is($cache->get($key)));
    }

}
