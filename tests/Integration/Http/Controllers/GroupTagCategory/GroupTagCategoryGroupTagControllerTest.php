<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\GroupTagCategory;

use BristolSU\ControlDB\Models\Tags\GroupTagCategory;
use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\Tests\ControlDB\TestCase;

class GroupTagCategoryGroupTagControllerTest extends TestCase
{

    /** @test */
    public function it_gets_all_tags_through_a_group_tag_category(){
        $groupTagCategory = factory(GroupTagCategory::class)->create();
        $groupTags = factory(GroupTag::class, 5)->create(['tag_category_id' => $groupTagCategory->id()]);

        $response = $this->getJson($this->apiUrl . '/group-tag-category/' . $groupTagCategory->id() . '/group-tag');
        $response->assertStatus(200);
        $response->assertPaginatedResponse();

        $response->assertPaginatedJsonCount(5);
        foreach($response->paginatedJson() as $groupTagThroughApi) {
            $this->assertArrayHasKey('id', $groupTagThroughApi);
            $this->assertEquals($groupTags->shift()->id(), $groupTagThroughApi['id']);
        }
    }
    
}