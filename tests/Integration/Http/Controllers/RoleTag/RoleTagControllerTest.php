<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\RoleTag;

use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\ControlDB\Models\Tags\RoleTagCategory;
use BristolSU\Tests\ControlDB\TestCase;

class RoleTagControllerTest extends TestCase
{

    /** @test */
    public function it_returns_all_role_tags(){
        $roleTags = factory(RoleTag::class, 5)->create();
        $response = $this->getJson($this->apiUrl . '/role-tag');
        $response->assertStatus(200);
        $response->assertPaginatedResponse();
        $response->assertPaginatedJsonCount(5);
        foreach($response->paginatedJson() as $roleTagThroughApi) {
            $this->assertArrayHasKey('id', $roleTagThroughApi);
            $this->assertEquals($roleTags->shift()->id(), $roleTagThroughApi['id']);
        }
    }

    /** @test */
    public function it_returns_a_single_roleTag(){
        $roleTag = factory(RoleTag::class)->create();
        $response = $this->getJson($this->apiUrl . '/role-tag/' . $roleTag->id());

        $response->assertStatus(200);
        $response->assertJson(['id' => $roleTag->id()]);
    }

    /** @test */
    public function it_updates_a_role_tag(){
        $tagCategory1 = factory(RoleTagCategory::class)->create();
        $tagCategory2 = factory(RoleTagCategory::class)->create();
        
        $roleTag = factory(RoleTag::class)->create([
            'name' => 'tag1', 'description' => 'ATag1', 'reference' => 'tag1a', 'tag_category_id' => $tagCategory1->id()
        ]);

        $this->assertDatabaseHas('control_tags', [
            'name' => 'tag1', 'description' => 'ATag1', 'reference' => 'tag1a', 'tag_category_id' => $tagCategory1->id()
        ]);

        $response = $this->patchJson($this->apiUrl . '/role-tag/' . $roleTag->id(), [
            'name' => 'tag2', 'description' => 'ATag2', 'reference' => 'tag2a', 'tag_category_id' => $tagCategory2->id()
        ]);
        
        $response->assertStatus(200);

        $this->assertDatabaseHas('control_tags', [
            'name' => 'tag2', 'description' => 'ATag2', 'reference' => 'tag2a', 'tag_category_id' => $tagCategory2->id()
        ]);

    }

    /** @test */
    public function it_creates_a_role_tag(){
        $tagCategory = factory(RoleTagCategory::class)->create();

        $response = $this->postJson($this->apiUrl . '/role-tag', [
            'name' => 'tag1', 'description' => 'ATag1', 'reference' => 'tag1a', 'tag_category_id' => $tagCategory->id()
        ]);

        $response->assertStatus(201);

        $response->assertJsonFragment([
            'name' => 'tag1', 'description' => 'ATag1', 'reference' => 'tag1a', 'tag_category_id' => $tagCategory->id()
        ]);

        $this->assertDatabaseHas('control_tags', [
            'name' => 'tag1', 'description' => 'ATag1', 'reference' => 'tag1a', 'tag_category_id' => $tagCategory->id()
        ]);
    }


    /** @test */
    public function it_deletes_a_role_tag(){
        $roleTag = factory(RoleTag::class)->create();

        $this->assertDatabaseHas('control_tags', [
            'id' => $roleTag->id
        ]);

        $response = $this->deleteJson($this->apiUrl . '/role-tag/' . $roleTag->id());

        $this->assertSoftDeleted('control_tags', [
            'id' => $roleTag->id
        ]);

        $response->assertStatus(200);
    }

}