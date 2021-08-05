<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\RoleTagCategory;

use BristolSU\ControlDB\Models\Tags\RoleTagCategory;
use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\Tests\ControlDB\TestCase;

class RoleTagCategoryRoleTagControllerTest extends TestCase
{

    /** @test */
    public function it_gets_all_tags_through_a_role_tag_category(){
        $roleTagCategory = RoleTagCategory::factory()->create();
        $roleTags = RoleTag::factory()->count(5)->create(['tag_category_id' => $roleTagCategory->id()]);

        $response = $this->getJson($this->apiUrl . '/role-tag-category/' . $roleTagCategory->id() . '/role-tag');
        $response->assertStatus(200);
        $response->assertPaginatedResponse();

        $response->assertPaginatedJsonCount(5);
        foreach($response->paginatedJson() as $roleTagThroughApi) {
            $this->assertArrayHasKey('id', $roleTagThroughApi);
            $this->assertEquals($roleTags->shift()->id(), $roleTagThroughApi['id']);
        }
    }

}
