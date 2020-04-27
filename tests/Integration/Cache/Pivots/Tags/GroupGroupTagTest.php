<?php

namespace BristolSU\Tests\ControlDB\Integration\Cache\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\GroupGroupTag;
use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;
use Prophecy\Argument;

class GroupGroupTagTest extends TestCase
{
    /** @test */
    public function addTagToGroup_does_not_save_in_cache()
    {
        $groupTag = factory(GroupTag::class)->create();
        $group = factory(Group::class)->create();

        $groupGroupTagRepository = $this->prophesize(GroupGroupTag::class);
        $groupGroupTagRepository->addTagToGroup(Argument::that(function ($arg) use ($groupTag) {
            return $arg instanceof GroupTag && $arg->is($groupTag);
        }), Argument::that(function ($arg) use ($group) {
            return $arg instanceof Group && $arg->is($group);
        }))->shouldBeCalled();

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $groupGroupTagCache = new \BristolSU\ControlDB\Cache\Pivots\Tags\GroupGroupTag($groupGroupTagRepository->reveal(), $cache->reveal());

        $groupGroupTagCache->addTagToGroup($groupTag, $group);
    }

    /** @test */
    public function removeTagFromGroup_does_not_save_in_cache()
    {
        $groupTag = factory(GroupTag::class)->create();
        $group = factory(Group::class)->create();

        $groupGroupTagRepository = $this->prophesize(GroupGroupTag::class);
        $groupGroupTagRepository->removeTagFromGroup(Argument::that(function ($arg) use ($groupTag) {
            return $arg instanceof GroupTag && $arg->is($groupTag);
        }), Argument::that(function ($arg) use ($group) {
            return $arg instanceof Group && $arg->is($group);
        }))->shouldBeCalled();

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $groupGroupTagCache = new \BristolSU\ControlDB\Cache\Pivots\Tags\GroupGroupTag($groupGroupTagRepository->reveal(), $cache->reveal());

        $groupGroupTagCache->removeTagFromGroup($groupTag, $group);
    }

    /** @test */
    public function getTagsThroughGroup_saves_the_tags_in_the_cache()
    {
        $groupTags = factory(GroupTag::class, 5)->create();
        $group = factory(Group::class)->create();

        $groupGroupTagRepository = $this->prophesize(GroupGroupTag::class);
        $groupGroupTagRepository->getTagsThroughGroup(Argument::that(function ($arg) use ($group) {
            return $arg instanceof Group && $arg->is($group);
        }))->shouldBeCalled()->willReturn($groupTags);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Pivots\Tags\GroupGroupTag::class . '@getTagsThroughGroup:' . $group->id();

        $groupGroupTagCache = new \BristolSU\ControlDB\Cache\Pivots\Tags\GroupGroupTag($groupGroupTagRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertCount(5, $groupGroupTagCache->getTagsThroughGroup($group));
        $this->assertTrue($cache->has($key));
        $this->assertInstanceOf(Collection::class, $cache->get($key));
        $this->assertContainsOnlyInstancesOf(GroupTag::class, $cache->get($key));
        $this->assertCount(5, $cache->get($key));
    }

    /** @test */
    public function getGroupsThroughTag_saves_the_groups_in_the_cache()
    {
        $groups = factory(Group::class, 5)->create();
        $groupTag = factory(GroupTag::class)->create();

        $groupGroupTagRepository = $this->prophesize(GroupGroupTag::class);
        $groupGroupTagRepository->getGroupsThroughTag(Argument::that(function ($arg) use ($groupTag) {
            return $arg instanceof GroupTag && $arg->is($groupTag);
        }))->shouldBeCalled()->willReturn($groups);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Pivots\Tags\GroupGroupTag::class . '@getGroupsThroughTag:' . $groupTag->id();

        $groupTagTagCache = new \BristolSU\ControlDB\Cache\Pivots\Tags\GroupGroupTag($groupGroupTagRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertCount(5, $groupTagTagCache->getGroupsThroughTag($groupTag));
        $this->assertTrue($cache->has($key));
        $this->assertInstanceOf(Collection::class, $cache->get($key));
        $this->assertContainsOnlyInstancesOf(Group::class, $cache->get($key));
        $this->assertCount(5, $cache->get($key));
    }
}