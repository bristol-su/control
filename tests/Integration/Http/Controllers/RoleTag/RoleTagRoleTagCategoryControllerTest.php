<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\RoleTag;

use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\ControlDB\Models\Tags\RoleTagCategory;
use BristolSU\Tests\ControlDB\TestCase;

class RoleTagRoleTagCategoryControllerTest extends TestCase
{

    /** @test */
    public function it_gets_the_category_of_the_given_tag(){
        $tagCategory = factory(RoleTagCategory::class)->create(['id' => 10]);
        $tag = factory(RoleTag::class)->create(['id' => 20, 'tag_category_id' => $tagCategory->id()]);
        
        $response = $this->getJson($this->apiUrl . '/role-tag/' . $tag->id() . '/role-tag-category');
        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $tagCategory->id()]);
    }
    
}