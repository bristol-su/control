<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\UserTag;

use BristolSU\ControlDB\Models\Tags\UserTag;
use BristolSU\ControlDB\Models\Tags\UserTagCategory;
use BristolSU\Tests\ControlDB\TestCase;

class UserTagUserTagCategoryControllerTest extends TestCase
{

    /** @test */
    public function it_gets_the_category_of_the_given_tag(){
        $tagCategory = UserTagCategory::factory()->create(['id' => 10]);
        $tag = UserTag::factory()->create(['id' => 20, 'tag_category_id' => $tagCategory->id()]);
        
        $response = $this->getJson($this->apiUrl . '/user-tag/' . $tag->id() . '/user-tag-category');
        
        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $tagCategory->id()]);
    }
    
}
