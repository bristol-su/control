<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories\Pivots\Tags;

use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\ControlDB\Models\Pivots\Tags\GroupGroupTag;
use BristolSU\ControlDB\Repositories\Pivots\Tags\GroupGroupTag as GroupGroupTagRepository;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Collection;

class GroupGroupTagTest extends TestCase
{

    /** @test */
    public function it_gets_all_tags_through_a_group(){
        $group = Group::factory()->create();
        $groupTagsForGroup = GroupTag::factory()->count(10)->create();
        $groupTagsNotForGroup = GroupTag::factory()->count(10)->create();

        foreach($groupTagsForGroup as $groupTag) {
            GroupGroupTag::create(['tag_id' => $groupTag->id(), 'taggable_id' => $group->id()]);
        }

        $groupGroupTag = new GroupGroupTagRepository();
        $retrievedGroupTags = $groupGroupTag->getTagsThroughGroup($group);

        $this->assertEquals(10, $retrievedGroupTags->count());
        $this->assertContainsOnlyInstancesOf(GroupTag::class, $retrievedGroupTags);
        foreach($groupTagsForGroup as $groupTag) {
            $this->assertTrue($groupTag->is($retrievedGroupTags->shift()));
        }
    }

    /** @test */
    public function it_gets_all_groups_tagged_with_a_tag(){
        $groupTag = GroupTag::factory()->create();
        $groupsForGroupTag = Group::factory()->count(10)->create();
        $groupsNotForGroupTag = Group::factory()->count(10)->create();

        foreach($groupsForGroupTag as $group) {
            GroupGroupTag::create(['tag_id' => $groupTag->id(), 'taggable_id' => $group->id()]);
        }

        $groupGroupTag = new GroupGroupTagRepository();
        $retrievedGroups = $groupGroupTag->getGroupsThroughTag($groupTag);

        $this->assertEquals(10, $retrievedGroups->count());
        $this->assertContainsOnlyInstancesOf(Group::class, $retrievedGroups);
        foreach($groupsForGroupTag as $group) {
            $this->assertTrue($group->is($retrievedGroups->shift()));
        }
    }



    /** @test */
    public function addTagToGroup_adds_a_tag_to_a_group()
    {
        $group = Group::factory()->create();
        $groupTag = GroupTag::factory()->create();

        $groupGroupTag = new \BristolSU\ControlDB\Repositories\Pivots\Tags\GroupGroupTag();
        $this->assertEquals(0, $groupGroupTag->getTagsThroughGroup($group)->count());

        $groupGroupTag->addTagToGroup($groupTag, $group);

        $this->assertEquals(1, $groupGroupTag->getTagsThroughGroup($group)->count());
        $this->assertInstanceOf(GroupTag::class, $groupGroupTag->getTagsThroughGroup($group)->first());
        $this->assertTrue($groupTag->is($groupGroupTag->getTagsThroughGroup($group)->first()));
    }

    /** @test */
    public function removeTagFromGroup_removes_a_tag_from_a_group()
    {
        $group = Group::factory()->create();
        $groupTag = GroupTag::factory()->create();

        GroupGroupTag::create([
            'taggable_id' => $group->id(), 'tag_id' => $groupTag->id()
        ]);

        $groupGroupTag = new \BristolSU\ControlDB\Repositories\Pivots\Tags\GroupGroupTag();

        $this->assertEquals(1, $groupGroupTag->getTagsThroughGroup($group)->count());
        $this->assertInstanceOf(GroupTag::class, $groupGroupTag->getTagsThroughGroup($group)->first());
        $this->assertTrue($groupTag->is($groupGroupTag->getTagsThroughGroup($group)->first()));

        $groupGroupTag->removeTagFromGroup($groupTag, $group);

        $this->assertEquals(0, $groupGroupTag->getTagsThroughGroup($group)->count());
    }
}
