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
        $groupTag = GroupTag::factory()->create();
        $group = Group::factory()->create();

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
        $groupTag = GroupTag::factory()->create();
        $group = Group::factory()->create();

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
        $groupTags = GroupTag::factory()->count(5)->create();
        $group = Group::factory()->create();

        $baseGroupGroupTagRepository = $this->prophesize(GroupGroupTag::class);
        $baseGroupGroupTagRepository->getTagsThroughGroup(Argument::that(function ($arg) use ($group) {
            return $arg instanceof Group && $arg->is($group);
        }))->shouldBeCalledTimes(1)->willReturn($groupTags);

        $groupGroupTagCache = new \BristolSU\ControlDB\Cache\Pivots\Tags\GroupGroupTag($baseGroupGroupTagRepository->reveal(), app(Repository::class));

        $assertGroupTags = function($groupTags) {
            $this->assertInstanceOf(Collection::class, $groupTags);
            $this->assertContainsOnlyInstancesOf(GroupTag::class, $groupTags);
            $this->assertCount(5, $groupTags);
        };

        // The underlying instance should only be called once
        $assertGroupTags($groupGroupTagCache->getTagsThroughGroup($group));
        $assertGroupTags($groupGroupTagCache->getTagsThroughGroup($group));
    }

    /** @test */
    public function getGroupsThroughTag_saves_the_groups_in_the_cache()
    {
        $groups = Group::factory()->count(5)->create();
        $groupTag = GroupTag::factory()->create();

        $baseGroupGroupTagRepository = $this->prophesize(GroupGroupTag::class);
        $baseGroupGroupTagRepository->getGroupsThroughTag(Argument::that(function ($arg) use ($groupTag) {
            return $arg instanceof GroupTag && $arg->is($groupTag);
        }))->shouldBeCalledTimes(1)->willReturn($groups);

        $groupGroupTagCache = new \BristolSU\ControlDB\Cache\Pivots\Tags\GroupGroupTag($baseGroupGroupTagRepository->reveal(), app(Repository::class));

        $assertGroups = function($groups) {
            $this->assertInstanceOf(Collection::class, $groups);
            $this->assertContainsOnlyInstancesOf(Group::class, $groups);
            $this->assertCount(5, $groups);
        };

        // The underlying instance should only be called once
        $assertGroups($groupGroupTagCache->getGroupsThroughTag($groupTag));
        $assertGroups($groupGroupTagCache->getGroupsThroughTag($groupTag));

    }
}
