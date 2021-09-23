<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\GroupTag;

use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\ControlDB\Models\Tags\GroupTagCategory;
use BristolSU\Tests\ControlDB\TestCase;

class GroupTagGroupTagCategoryControllerTest extends TestCase
{

    /** @test */
    public function it_gets_the_category_of_the_given_tag(){
        $tagCategory = GroupTagCategory::factory()->create(['id' => 10]);
        $tag = GroupTag::factory()->create(['id' => 20, 'tag_category_id' => $tagCategory->id()]);
        
        $response = $this->getJson($this->apiUrl . '/group-tag/' . $tag->id() . '/group-tag-category');
        
        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $tagCategory->id()]);
    }
    
}
