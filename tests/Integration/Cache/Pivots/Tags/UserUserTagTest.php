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

        $baseUserUserTagRepository = $this->prophesize(UserUserTag::class);
        $baseUserUserTagRepository->getTagsThroughUser(Argument::that(function ($arg) use ($user) {
            return $arg instanceof User && $arg->is($user);
        }))->shouldBeCalledTimes(1)->willReturn($userTags);

        $userUserTagCache = new \BristolSU\ControlDB\Cache\Pivots\Tags\UserUserTag($baseUserUserTagRepository->reveal(), app(Repository::class));

        $assertUserTags = function($userTags) {
            $this->assertInstanceOf(Collection::class, $userTags);
            $this->assertContainsOnlyInstancesOf(UserTag::class, $userTags);
            $this->assertCount(5, $userTags);
        };

        // The underlying instance should only be called once
        $assertUserTags($userUserTagCache->getTagsThroughUser($user));
        $assertUserTags($userUserTagCache->getTagsThroughUser($user));
    }

    /** @test */
    public function getUsersThroughTag_saves_the_users_in_the_cache()
    {
        $users = User::factory()->count(5)->create();
        $userTag = UserTag::factory()->create();

        $baseUserUserTagRepository = $this->prophesize(UserUserTag::class);
        $baseUserUserTagRepository->getUsersThroughTag(Argument::that(function ($arg) use ($userTag) {
            return $arg instanceof UserTag && $arg->is($userTag);
        }))->shouldBeCalledTimes(1)->willReturn($users);

        $userUserTagCache = new \BristolSU\ControlDB\Cache\Pivots\Tags\UserUserTag($baseUserUserTagRepository->reveal(), app(Repository::class));

        $assertUsers = function($users) {
            $this->assertInstanceOf(Collection::class, $users);
            $this->assertContainsOnlyInstancesOf(User::class, $users);
            $this->assertCount(5, $users);
        };

        // The underlying instance should only be called once
        $assertUsers($userUserTagCache->getUsersThroughTag($userTag));
        $assertUsers($userUserTagCache->getUsersThroughTag($userTag));

    }
}
