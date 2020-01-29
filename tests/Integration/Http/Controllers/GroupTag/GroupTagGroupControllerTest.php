<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\GroupTag;

use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\ControlDB\Models\Group;
use BristolSU\Tests\ControlDB\TestCase;

class GroupTagGroupControllerTest extends TestCase
{
    /** @test */
    public function it_gets_all_groups_through_a_tag()
    {
        $groupTag = factory(GroupTag::class)->create();
        $groups = factory(Group::class, 5)->create();

        foreach ($groups as $group) {
            $groupTag->addGroup($group);
            $this->assertDatabaseHas('control_taggables', [
                'taggable_id' => $group->id(),
                'tag_id' => $groupTag->id(),
                'taggable_type' => 'group'
            ]);
        }

        $response = $this->getJson($this->apiUrl . '/group-tag/' . $groupTag->id() . '/group');
        $response->assertStatus(200);

        $response->assertJsonCount(5);
        foreach ($response->json() as $groupThroughApi) {
            $this->assertArrayHasKey('id', $groupThroughApi);
            $this->assertEquals($groups->shift()->id(), $groupThroughApi['id']);
        }
    }

    /** @test */
    public function it_tags_a_group()
    {
        $group = factory(Group::class)->create();
        $groupTag = factory(GroupTag::class)->create();

        $this->assertDatabaseMissing('control_taggables', [
            'taggable_id' => $group->id(),
            'tag_id' => $groupTag->id(),
            'taggable_type' => 'group'
        ]);

        $response = $this->patchJson(
            $this->apiUrl . '/group-tag/' . $groupTag->id() . '/group/' . $group->id()
        );

        $response->assertStatus(200);

        $this->assertDatabaseHas('control_taggables', [
            'taggable_id' => $group->id(),
            'tag_id' => $groupTag->id(),
            'taggable_type' => 'group'
        ]);
    }

    /** @test */
    public function it_untags_a_group()
    {
        $group = factory(Group::class)->create();
        $groupTag = factory(GroupTag::class)->create();

        $group->addTag($groupTag);

        $this->assertDatabaseHas('control_taggables', [
            'taggable_id' => $group->id(),
            'tag_id' => $groupTag->id(),
            'taggable_type' => 'group'
        ]);

        $response = $this->deleteJson(
            $this->apiUrl . '/group-tag/' . $groupTag->id() . '/group/' . $group->id()
        );

        $response->assertStatus(200);

        $this->assertSoftDeleted('control_taggables', [
            'taggable_id' => $group->id(),
            'tag_id' => $groupTag->id(),
            'taggable_type' => 'group'
        ]);


    }
}