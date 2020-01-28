<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories\Pivots\Tags;

use BristolSU\ControlDB\Models\User;
use BristolSU\ControlDB\Models\Tags\UserTag;
use BristolSU\ControlDB\Models\Pivots\Tags\UserUserTag;
use BristolSU\ControlDB\Repositories\Pivots\Tags\UserUserTag as UserUserTagRepository;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Collection;

class UserUserTagTest extends TestCase
{
    
    /** @test */
    public function it_gets_all_tags_through_a_user(){
        $user = factory(User::class)->create();
        $userTagsForUser = factory(UserTag::class, 10)->create();
        $userTagsNotForUser = factory(UserTag::class, 10)->create();
        
        foreach($userTagsForUser as $userTag) {
            UserUserTag::create(['tag_id' => $userTag->id(), 'taggable_id' => $user->id()]);
        }
        
        $userUserTag = new UserUserTagRepository();
        $retrievedUserTags = $userUserTag->getTagsThroughUser($user);
        
        $this->assertEquals(10, $retrievedUserTags->count());
        $this->assertContainsOnlyInstancesOf(UserTag::class, $retrievedUserTags);
        foreach($userTagsForUser as $userTag) {
            $this->assertTrue($userTag->is($retrievedUserTags->shift()));
        }
    }
    
    /** @test */
    public function it_gets_all_users_tagged_with_a_tag(){
        $userTag = factory(UserTag::class)->create();
        $usersForUserTag = factory(User::class, 10)->create();
        $usersNotForUserTag = factory(User::class, 10)->create();

        foreach($usersForUserTag as $user) {
            UserUserTag::create(['tag_id' => $userTag->id(), 'taggable_id' => $user->id()]);
        }

        $userUserTag = new UserUserTagRepository();
        $retrievedUsers = $userUserTag->getUsersThroughTag($userTag);

        $this->assertEquals(10, $retrievedUsers->count());
        $this->assertContainsOnlyInstancesOf(User::class, $retrievedUsers);
        foreach($usersForUserTag as $user) {
            $this->assertTrue($user->is($retrievedUsers->shift()));
        }
    }
    
    

    /** @test */
    public function addTagToUser_adds_a_tag_to_a_user()
    {
        $user = factory(User::class)->create();
        $userTag = factory(UserTag::class)->create();

        $userUserTag = new \BristolSU\ControlDB\Repositories\Pivots\Tags\UserUserTag();
        $this->assertEquals(0, $userUserTag->getTagsThroughUser($user)->count());

        $userUserTag->addTagToUser($userTag, $user);

        $this->assertEquals(1, $userUserTag->getTagsThroughUser($user)->count());
        $this->assertInstanceOf(UserTag::class, $userUserTag->getTagsThroughUser($user)->first());
        $this->assertTrue($userTag->is($userUserTag->getTagsThroughUser($user)->first()));
    }

    /** @test */
    public function removeTagFromUser_removes_a_tag_from_a_user()
    {
        $user = factory(User::class)->create();
        $userTag = factory(UserTag::class)->create();
        $userUserTag = new \BristolSU\ControlDB\Repositories\Pivots\Tags\UserUserTag();

        UserUserTag::create([
            'taggable_id' => $user->id(), 'tag_id' => $userTag->id()
        ]);
        
        $this->assertEquals(1, $userUserTag->getTagsThroughUser($user)->count());
        $this->assertInstanceOf(UserTag::class, $userUserTag->getTagsThroughUser($user)->first());
        $this->assertTrue($userTag->is($userUserTag->getTagsThroughUser($user)->first()));

        $userUserTag->removeTagFromUser($userTag, $user);
    
        $this->assertEquals(0, $userUserTag->getTagsThroughUser($user)->count());
    }
}