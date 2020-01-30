<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\UserTagCategory;

use BristolSU\ControlDB\Models\Tags\UserTagCategory;
use BristolSU\ControlDB\Models\Tags\UserTag;
use BristolSU\Tests\ControlDB\TestCase;

class UserTagCategoryUserTagControllerTest extends TestCase
{

    /** @test */
    public function it_gets_all_tags_through_a_user_tag_category(){
        $userTagCategory = factory(UserTagCategory::class)->create();
        $userTags = factory(UserTag::class, 5)->create(['tag_category_id' => $userTagCategory->id()]);

        $response = $this->getJson($this->apiUrl . '/user-tag-category/' . $userTagCategory->id() . '/user-tag');
        $response->assertStatus(200);

        $response->assertJsonCount(5);
        foreach($response->json() as $userTagThroughApi) {
            $this->assertArrayHasKey('id', $userTagThroughApi);
            $this->assertEquals($userTags->shift()->id(), $userTagThroughApi['id']);
        }
    }
    
}