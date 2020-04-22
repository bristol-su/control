<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\GroupTag;

use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\ControlDB\Models\Tags\GroupTagCategory;
use BristolSU\Tests\ControlDB\TestCase;

class GroupTagControllerTest extends TestCase
{

    /** @test */
    public function it_returns_all_group_tags(){
        $groupTags = factory(GroupTag::class, 5)->create();
        $response = $this->getJson($this->apiUrl . '/group-tag');
        $response->assertStatus(200);

        $response->assertPaginatedResponse();
        $response->assertPaginatedJsonCount(5);
        foreach($response->paginatedJson() as $groupTagThroughApi) {
            $this->assertArrayHasKey('id', $groupTagThroughApi);
            $this->assertEquals($groupTags->shift()->id(), $groupTagThroughApi['id']);
        }
    }

    /** @test */
    public function it_returns_a_single_groupTag(){
        $groupTag = factory(GroupTag::class)->create();
        $response = $this->getJson($this->apiUrl . '/group-tag/' . $groupTag->id());

        $response->assertStatus(200);
        $response->assertJson(['id' => $groupTag->id()]);
    }

    /** @test */
    public function it_updates_a_group_tag(){
        $tagCategory1 = factory(GroupTagCategory::class)->create();
        $tagCategory2 = factory(GroupTagCategory::class)->create();
        
        $groupTag = factory(GroupTag::class)->create([
            'name' => 'tag1', 'description' => 'ATag1', 'reference' => 'tag1a', 'tag_category_id' => $tagCategory1->id()
        ]);

        $this->assertDatabaseHas('control_tags', [
            'name' => 'tag1', 'description' => 'ATag1', 'reference' => 'tag1a', 'tag_category_id' => $tagCategory1->id()
        ]);

        $response = $this->patchJson($this->apiUrl . '/group-tag/' . $groupTag->id(), [
            'name' => 'tag2', 'description' => 'ATag2', 'reference' => 'tag2a', 'tag_category_id' => $tagCategory2->id()
        ]);
        
        $response->assertStatus(200);

        $this->assertDatabaseHas('control_tags', [
            'name' => 'tag2', 'description' => 'ATag2', 'reference' => 'tag2a', 'tag_category_id' => $tagCategory2->id()
        ]);

    }

    /** @test */
    public function it_creates_a_group_tag(){
        $tagCategory = factory(GroupTagCategory::class)->create();

        $response = $this->postJson($this->apiUrl . '/group-tag', [
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
    public function it_deletes_a_group_tag(){
        $groupTag = factory(GroupTag::class)->create();

        $this->assertDatabaseHas('control_tags', [
            'id' => $groupTag->id
        ]);

        $response = $this->deleteJson($this->apiUrl . '/group-tag/' . $groupTag->id());

        $this->assertSoftDeleted('control_tags', [
            'id' => $groupTag->id
        ]);

        $response->assertStatus(200);
    }

}