<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\UserTag;

use BristolSU\ControlDB\Models\Tags\UserTag;
use BristolSU\ControlDB\Models\Tags\UserTagCategory;
use BristolSU\Tests\ControlDB\TestCase;

class UserTagControllerTest extends TestCase
{

    /** @test */
    public function it_returns_all_user_tags(){
        $userTags = UserTag::factory()->count(5)->create();
        $response = $this->getJson($this->apiUrl . '/user-tag');
        $response->assertStatus(200);
        $response->assertPaginatedResponse();

        $response->assertPaginatedJsonCount(5);
        foreach($response->paginatedJson() as $userTagThroughApi) {
            $this->assertArrayHasKey('id', $userTagThroughApi);
            $this->assertEquals($userTags->shift()->id(), $userTagThroughApi['id']);
        }
    }

    /** @test */
    public function it_returns_a_single_userTag(){
        $userTag = UserTag::factory()->create();
        $response = $this->getJson($this->apiUrl . '/user-tag/' . $userTag->id());

        $response->assertStatus(200);
        $response->assertJson(['id' => $userTag->id()]);
    }

    /** @test */
    public function it_updates_a_user_tag(){
        $tagCategory1 = UserTagCategory::factory()->create();
        $tagCategory2 = UserTagCategory::factory()->create();

        $userTag = UserTag::factory()->create([
            'name' => 'tag1', 'description' => 'ATag1', 'reference' => 'tag1a', 'tag_category_id' => $tagCategory1->id()
        ]);

        $this->assertDatabaseHas('control_tags', [
            'name' => 'tag1', 'description' => 'ATag1', 'reference' => 'tag1a', 'tag_category_id' => $tagCategory1->id()
        ]);

        $response = $this->patchJson($this->apiUrl . '/user-tag/' . $userTag->id(), [
            'name' => 'tag2', 'description' => 'ATag2', 'reference' => 'tag2a', 'tag_category_id' => $tagCategory2->id()
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('control_tags', [
            'name' => 'tag2', 'description' => 'ATag2', 'reference' => 'tag2a', 'tag_category_id' => $tagCategory2->id()
        ]);

    }

    /** @test */
    public function it_creates_a_user_tag(){
        $tagCategory = UserTagCategory::factory()->create();

        $response = $this->postJson($this->apiUrl . '/user-tag', [
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
    public function it_deletes_a_user_tag(){
        $userTag = UserTag::factory()->create();

        $this->assertDatabaseHas('control_tags', [
            'id' => $userTag->id
        ]);

        $response = $this->deleteJson($this->apiUrl . '/user-tag/' . $userTag->id());

        $this->assertSoftDeleted('control_tags', [
            'id' => $userTag->id
        ]);

        $response->assertStatus(200);
    }

}
