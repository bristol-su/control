<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\PositionTagCategory;

use BristolSU\ControlDB\Models\Tags\PositionTagCategory;
use BristolSU\ControlDB\Models\Tags\PositionTag;
use BristolSU\Tests\ControlDB\TestCase;

class PositionTagCategoryPositionTagControllerTest extends TestCase
{

    /** @test */
    public function it_gets_all_tags_through_a_position_tag_category(){
        $positionTagCategory = PositionTagCategory::factory()->create();
        $positionTags = PositionTag::factory()->count(5)->create(['tag_category_id' => $positionTagCategory->id()]);

        $response = $this->getJson($this->apiUrl . '/position-tag-category/' . $positionTagCategory->id() . '/position-tag');
        $response->assertStatus(200);
        $response->assertPaginatedResponse();

        $response->assertPaginatedJsonCount(5);
        foreach($response->paginatedJson() as $positionTagThroughApi) {
            $this->assertArrayHasKey('id', $positionTagThroughApi);
            $this->assertEquals($positionTags->shift()->id(), $positionTagThroughApi['id']);
        }
    }

}
