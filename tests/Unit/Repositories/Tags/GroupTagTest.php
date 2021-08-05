<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories\Tags;

use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\ControlDB\Models\Tags\GroupTagCategory;
use BristolSU\ControlDB\Models\Tags\UserTag;
use BristolSU\ControlDB\Models\Tags\UserTagCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use BristolSU\Tests\ControlDB\TestCase;

class GroupTagTest extends TestCase
{

    /** @test */
    public function getById_returns_a_group_tag_model_with_the_corresponding_id(){
        $groupTag = GroupTag::factory()->create(['id' => 2]);
        $groupTagRepo = new \BristolSU\ControlDB\Repositories\Tags\GroupTag();
        $this->assertTrue(
            $groupTag->is($groupTagRepo->getById(2))
        );
    }

    /** @test */
    public function getById_throws_a_modelNotFoundException_if_group_tag_does_not_exist(){
        $this->expectException(ModelNotFoundException::class);
        $groupTagRepo = new \BristolSU\ControlDB\Repositories\Tags\GroupTag();
        $groupTagRepo->getById(5);
    }

    /** @test */
    public function all_returns_all_group_tags(){
        $groupTags = GroupTag::factory()->count(15)->create();
        $groupTagRepo = new \BristolSU\ControlDB\Repositories\Tags\GroupTag();
        $allTags = $groupTagRepo->all();
        $this->assertInstanceOf(Collection::class, $allTags);
        foreach($groupTags as $groupTag) {
            $this->assertTrue($groupTag->is(
                $allTags->shift()
            ));
        }
    }

    /** @test */
    public function getTagByFullReference_returns_a_tag_given_the_full_reference(){
        $groupTagCategory = GroupTagCategory::factory()->create(['reference' => 'ref1']);
        $groupTag = GroupTag::factory()->create(['reference' => 'ref2', 'tag_category_id' => $groupTagCategory->id]);

        $groupTagRepo = new \BristolSU\ControlDB\Repositories\Tags\GroupTag();
        $groupTagFromRepo = $groupTagRepo->getTagByFullReference('ref1.ref2');
        $this->assertInstanceOf(GroupTag::class, $groupTagFromRepo);
        $this->assertTrue($groupTag->is($groupTagFromRepo));

    }

    /** @test */
    public function getTagByFullReference_throws_an_exception_if_group_tag_not_found(){
        $this->expectException(ModelNotFoundException::class);
        $groupTagRepo = new \BristolSU\ControlDB\Repositories\Tags\GroupTag();
        $groupTagRepo->getTagByFullReference('nota.validref');
    }


    /** @test */
    public function create_creates_a_group_tag_model(){
        $groupTagRepo = new \BristolSU\ControlDB\Repositories\Tags\GroupTag();
        $groupTagRepo->create('Name', 'Description', 'reference', 1);

        $this->assertDatabaseHas('control_tags', [
            'name' => 'Name',
            'description' => 'Description',
            'reference' => 'reference',
            'tag_category_id' => 1
        ]);
    }

    /** @test */
    public function create_returns_a_group_tag_model(){
        $groupTagRepo = new \BristolSU\ControlDB\Repositories\Tags\GroupTag();
        $groupTag = $groupTagRepo->create('Name', 'Description', 'reference', 1);

        $this->assertInstanceOf(GroupTag::class, $groupTag);
        $this->assertEquals('Name', $groupTag->name());
        $this->assertEquals('Description', $groupTag->description());
        $this->assertEquals('reference', $groupTag->reference());
        $this->assertEquals(1, $groupTag->categoryId());
    }

    /** @test */
    public function delete_deletes_a_group_tag_model(){
        $groupTag = GroupTag::factory()->create();
        $groupTagRepo = new \BristolSU\ControlDB\Repositories\Tags\GroupTag();
        $groupTagRepo->delete($groupTag->id());

        $groupTag->refresh();
        $this->assertTrue($groupTag->trashed());
    }

    /** @test */
    public function allThroughTagCategory_returns_all_tags_through_a_tag_category(){
        $category = GroupTagCategory::factory()->create();
        $tags = GroupTag::factory()->count(10)->create(['tag_category_id' => $category->id()]);
        GroupTag::factory()->count(10)->create();

        $groupTagRepo = new \BristolSU\ControlDB\Repositories\Tags\GroupTag();
        $tagsFromRepo = $groupTagRepo->allThroughTagCategory($category);
        $this->assertContainsOnlyInstancesOf(GroupTag::class, $tagsFromRepo);
        foreach($tags as $tag) {
            $this->assertTrue($tag->is(
                $tagsFromRepo->shift()
            ));
        }
    }

    /** @test */
    public function update_updates_a_group_tag_category()
    {
        $oldTagCategory = GroupTagCategory::factory()->create();
        $newTagCategory = GroupTagCategory::factory()->create();
        $groupTag = GroupTag::factory()->create([
            'name' => 'TagName',
            'description' => 'TagDesc',
            'reference' => 'ref',
            'tag_category_id' => $oldTagCategory->id
        ]);
        $this->assertDatabaseHas('control_tags', [
            'id' => $groupTag->id(),
            'name' => 'TagName',
            'description' => 'TagDesc',
            'reference' => 'ref',
            'tag_category_id' => (string) $oldTagCategory->id,
        ]);
        $repository = new \BristolSU\ControlDB\Repositories\Tags\GroupTag();
        $repository->update($groupTag->id(), 'TagName2',  'TagDesc2', 'ref2', $newTagCategory->id());
        $this->assertDatabaseMissing('control_tags', [
            'id' => $groupTag->id(),
            'name' => 'TagName',
            'description' => 'TagDesc',
            'reference' => 'ref',
            'tag_category_id' => (string) $oldTagCategory->id,
        ]);
        $this->assertDatabaseHas('control_tags', [
            'id' => $groupTag->id(),
            'name' => 'TagName2',
            'description' => 'TagDesc2',
            'reference' => 'ref2',
            'tag_category_id' => (string) $newTagCategory->id,
        ]);

    }

    /** @test */
    public function update_returns_the_updated_group_tag_category()
    {
        $oldTagCategory = GroupTagCategory::factory()->create();
        $newTagCategory = GroupTagCategory::factory()->create();
        $groupTag = GroupTag::factory()->create([
            'name' => 'TagCategoryName',
            'description' => 'TagCategoryDesc',
            'reference' => 'ref',
            'tag_category_id' => $oldTagCategory->id()
        ]);
        $this->assertEquals('TagCategoryName', $groupTag->name());
        $this->assertEquals('TagCategoryDesc', $groupTag->description());
        $this->assertEquals('ref', $groupTag->reference());
        $this->assertEquals($oldTagCategory->id(), $groupTag->categoryId());

        $repository = new \BristolSU\ControlDB\Repositories\Tags\GroupTag();
        $updatedGroupTag = $repository->update($groupTag->id(), 'TagCategoryName2', 'TagCategoryDesc2', 'ref2', $newTagCategory->id());

        $this->assertEquals('TagCategoryName2', $updatedGroupTag->name());
        $this->assertEquals('TagCategoryDesc2', $updatedGroupTag->description());
        $this->assertEquals('ref2', $updatedGroupTag->reference());
        $this->assertEquals($newTagCategory->id(), $updatedGroupTag->categoryId());
    }

}
