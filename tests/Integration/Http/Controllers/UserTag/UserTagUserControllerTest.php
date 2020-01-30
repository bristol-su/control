<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\UserTag;

use BristolSU\ControlDB\Models\Tags\UserTag;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;

class UserTagUserControllerTest extends TestCase
{
    /** @test */
    public function it_gets_all_users_through_a_tag()
    {
        $userTag = factory(UserTag::class)->create();
        $users = factory(User::class, 5)->create();

        foreach ($users as $user) {
            $userTag->addUser($user);
            $this->assertDatabaseHas('control_taggables', [
                'taggable_id' => $user->id(),
                'tag_id' => $userTag->id(),
                'taggable_type' => 'user'
            ]);
        }

        $response = $this->getJson($this->apiUrl . '/user-tag/' . $userTag->id() . '/user');
        $response->assertStatus(200);

        $response->assertJsonCount(5);
        foreach ($response->json() as $userThroughApi) {
            $this->assertArrayHasKey('id', $userThroughApi);
            $this->assertEquals($users->shift()->id(), $userThroughApi['id']);
        }
    }

    /** @test */
    public function it_tags_a_user()
    {
        $user = factory(User::class)->create();
        $userTag = factory(UserTag::class)->create();

        $this->assertDatabaseMissing('control_taggables', [
            'taggable_id' => $user->id(),
            'tag_id' => $userTag->id(),
            'taggable_type' => 'user'
        ]);

        $response = $this->patchJson(
            $this->apiUrl . '/user-tag/' . $userTag->id() . '/user/' . $user->id()
        );

        $response->assertStatus(200);

        $this->assertDatabaseHas('control_taggables', [
            'taggable_id' => $user->id(),
            'tag_id' => $userTag->id(),
            'taggable_type' => 'user'
        ]);
    }

    /** @test */
    public function it_untags_a_user()
    {
        $user = factory(User::class)->create();
        $userTag = factory(UserTag::class)->create();

        $user->addTag($userTag);

        $this->assertDatabaseHas('control_taggables', [
            'taggable_id' => $user->id(),
            'tag_id' => $userTag->id(),
            'taggable_type' => 'user'
        ]);

        $response = $this->deleteJson(
            $this->apiUrl . '/user-tag/' . $userTag->id() . '/user/' . $user->id()
        );

        $response->assertStatus(200);

        $this->assertSoftDeleted('control_taggables', [
            'taggable_id' => $user->id(),
            'tag_id' => $userTag->id(),
            'taggable_type' => 'user'
        ]);


    }
}