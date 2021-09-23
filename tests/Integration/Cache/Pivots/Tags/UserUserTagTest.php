<?php

namespace BristolSU\Tests\ControlDB\Integration\Cache\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\UserUserTag;
use BristolSU\ControlDB\Models\User;
use BristolSU\ControlDB\Models\Tags\UserTag;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;
use Prophecy\Argument;

class UserUserTagTest extends TestCase
{
    /** @test */
    public function addTagToUser_does_not_save_in_cache()
    {
        $userTag = UserTag::factory()->create();
        $user = User::factory()->create();

        $userUserTagRepository = $this->prophesize(UserUserTag::class);
        $userUserTagRepository->addTagToUser(Argument::that(function ($arg) use ($userTag) {
            return $arg instanceof UserTag && $arg->is($userTag);
        }), Argument::that(function ($arg) use ($user) {
            return $arg instanceof User && $arg->is($user);
        }))->shouldBeCalled();

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $userUserTagCache = new \BristolSU\ControlDB\Cache\Pivots\Tags\UserUserTag($userUserTagRepository->reveal(), $cache->reveal());

        $userUserTagCache->addTagToUser($userTag, $user);
    }

    /** @test */
    public function removeTagFromUser_does_not_save_in_cache()
    {
        $userTag = UserTag::factory()->create();
        $user = User::factory()->create();

        $userUserTagRepository = $this->prophesize(UserUserTag::class);
        $userUserTagRepository->removeTagFromUser(Argument::that(function ($arg) use ($userTag) {
            return $arg instanceof UserTag && $arg->is($userTag);
        }), Argument::that(function ($arg) use ($user) {
            return $arg instanceof User && $arg->is($user);
        }))->shouldBeCalled();

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $userUserTagCache = new \BristolSU\ControlDB\Cache\Pivots\Tags\UserUserTag($userUserTagRepository->reveal(), $cache->reveal());

        $userUserTagCache->removeTagFromUser($userTag, $user);
    }

    /** @test */
    public function getTagsThroughUser_saves_the_tags_in_the_cache()
    {
        $userTags = UserTag::factory()->count(5)->create();
        $user = User::factory()->create();

        $userUserTagRepository = $this->prophesize(UserUserTag::class);
        $userUserTagRepository->getTagsThroughUser(Argument::that(function ($arg) use ($user) {
            return $arg instanceof User && $arg->is($user);
        }))->shouldBeCalled()->willReturn($userTags);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Pivots\Tags\UserUserTag::class . '@getTagsThroughUser:' . $user->id();

        $userUserTagCache = new \BristolSU\ControlDB\Cache\Pivots\Tags\UserUserTag($userUserTagRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertCount(5, $userUserTagCache->getTagsThroughUser($user));
        $this->assertTrue($cache->has($key));
        $this->assertInstanceOf(Collection::class, $cache->get($key));
        $this->assertContainsOnlyInstancesOf(UserTag::class, $cache->get($key));
        $this->assertCount(5, $cache->get($key));
    }

    /** @test */
    public function getUsersThroughTag_saves_the_users_in_the_cache()
    {
        $users = User::factory()->count(5)->create();
        $userTag = UserTag::factory()->create();

        $userUserTagRepository = $this->prophesize(UserUserTag::class);
        $userUserTagRepository->getUsersThroughTag(Argument::that(function ($arg) use ($userTag) {
            return $arg instanceof UserTag && $arg->is($userTag);
        }))->shouldBeCalled()->willReturn($users);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Pivots\Tags\UserUserTag::class . '@getUsersThroughTag:' . $userTag->id();

        $userTagTagCache = new \BristolSU\ControlDB\Cache\Pivots\Tags\UserUserTag($userUserTagRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertCount(5, $userTagTagCache->getUsersThroughTag($userTag));
        $this->assertTrue($cache->has($key));
        $this->assertInstanceOf(Collection::class, $cache->get($key));
        $this->assertContainsOnlyInstancesOf(User::class, $cache->get($key));
        $this->assertCount(5, $cache->get($key));
    }
}
