<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\PositionTag;

use BristolSU\ControlDB\Models\Tags\PositionTag;
use BristolSU\ControlDB\Models\Tags\PositionTagCategory;
use BristolSU\Tests\ControlDB\TestCase;

class PositionTagPositionTagCategoryControllerTest extends TestCase
{

    /** @test */
    public function it_gets_the_category_of_the_given_tag(){
        $tagCategory = factory(PositionTagCategory::class)->create(['id' => 10]);
        $tag = factory(PositionTag::class)->create(['id' => 20, 'tag_category_id' => $tagCategory->id()]);
        
        $response = $this->getJson($this->apiUrl . '/position-tag/' . $tag->id() . '/position-tag-category');
        
        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $tagCategory->id()]);
    }
    
}