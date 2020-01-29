<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\User;

use BristolSU\ControlDB\Models\User;
use BristolSU\ControlDB\Models\Tags\UserTag;
use BristolSU\Tests\ControlDB\TestCase;

class UserUserTagControllerTest extends TestCase
{

    /** @test */
    public function it_gets_all_tags_through_a_user(){
        $user = factory(User::class)->create();
        $userTags = factory(UserTag::class, 5)->create();
        
        foreach($userTags as $userTag) {
            $user->addTag($userTag);
            $this->assertDatabaseHas('control_taggables', [
                'taggable_id' => $user->id(),
                'tag_id' => $userTag->id(),
                'taggable_type' => 'user'
            ]);
        }
        
        $response = $this->getJson($this->apiUrl . '/user/' . $user->id() . '/tag');
        $response->assertStatus(200);
        
        $response->assertJsonCount(5);
        foreach($response->json() as $userTagThroughApi) {
            $this->assertArrayHasKey('id', $userTagThroughApi);
            $this->assertEquals($userTags->shift()->id(), $userTagThroughApi['id']);
        }
    }
    
    /** @test */
    public function it_tags_a_user(){
        $user = factory(User::class)->create();
        $userTag = factory(UserTag::class)->create();
        
        $this->assertDatabaseMissing('control_taggables', [
            'taggable_id' => $user->id(),
            'tag_id' => $userTag->id(),
            'taggable_type' => 'user'
        ]);
        
        $response = $this->patchJson(
            $this->apiUrl . '/user/' . $user->id() . '/tag/' . $userTag->id()
        );

        $response->assertStatus(200);
        
        $this->assertDatabaseHas('control_taggables', [
            'taggable_id' => $user->id(),
            'tag_id' => $userTag->id(),
            'taggable_type' => 'user'
        ]);
    }
    
    /** @test */
    public function it_untags_a_user(){
        $user = factory(User::class)->create();
        $userTag = factory(UserTag::class)->create();

        $user->addTag($userTag);
        
        $this->assertDatabaseHas('control_taggables', [
            'taggable_id' => $user->id(),
            'tag_id' => $userTag->id(),
            'taggable_type' => 'user'
        ]);

        $response = $this->deleteJson(
            $this->apiUrl . '/user/' . $user->id() . '/tag/' . $userTag->id()
        );

        $response->assertStatus(200);
        
        $this->assertSoftDeleted('control_taggables', [
            'taggable_id' => $user->id(),
            'tag_id' => $userTag->id(),
            'taggable_type' => 'user'
            ]);


    }
    
}