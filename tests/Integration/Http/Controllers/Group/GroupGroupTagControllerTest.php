<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\Group;

use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\Tests\ControlDB\TestCase;

class GroupGroupTagControllerTest extends TestCase
{

    /** @test */
    public function it_gets_all_tags_through_a_group(){
        $group = Group::factory()->create();
        $groupTags = GroupTag::factory()->count(5)->create();

        foreach($groupTags as $groupTag) {
            $group->addTag($groupTag);
            $this->assertDatabaseHas('control_taggables', [
                'taggable_id' => $group->id(),
                'tag_id' => $groupTag->id(),
                'taggable_type' => 'group'
            ]);
        }

        $response = $this->getJson($this->apiUrl . '/group/' . $group->id() . '/tag');
        $response->assertStatus(200);

        $response->assertPaginatedJsonCount(5);
        $response->assertPaginatedResponse();
        foreach($response->paginatedJson() as $groupTagThroughApi) {
            $this->assertArrayHasKey('id', $groupTagThroughApi);
            $this->assertEquals($groupTags->shift()->id(), $groupTagThroughApi['id']);
        }
    }

    /** @test */
    public function it_tags_a_group(){
        $group = Group::factory()->create();
        $groupTag = GroupTag::factory()->create();

        $this->assertDatabaseMissing('control_taggables', [
            'taggable_id' => $group->id(),
            'tag_id' => $groupTag->id(),
            'taggable_type' => 'group'
        ]);

        $response = $this->patchJson(
            $this->apiUrl . '/group/' . $group->id() . '/tag/' . $groupTag->id()
        );

        $response->assertStatus(200);

        $this->assertDatabaseHas('control_taggables', [
            'taggable_id' => $group->id(),
            'tag_id' => $groupTag->id(),
            'taggable_type' => 'group'
        ]);
    }

    /** @test */
    public function it_untags_a_group(){
        $group = Group::factory()->create();
        $groupTag = GroupTag::factory()->create();

        $group->addTag($groupTag);

        $this->assertDatabaseHas('control_taggables', [
            'taggable_id' => $group->id(),
            'tag_id' => $groupTag->id(),
            'taggable_type' => 'group'
        ]);

        $response = $this->deleteJson(
            $this->apiUrl . '/group/' . $group->id() . '/tag/' . $groupTag->id()
        );

        $response->assertStatus(200);

        $this->assertSoftDeleted('control_taggables', [
            'taggable_id' => $group->id(),
            'tag_id' => $groupTag->id(),
            'taggable_type' => 'group'
        ]);


    }

}
