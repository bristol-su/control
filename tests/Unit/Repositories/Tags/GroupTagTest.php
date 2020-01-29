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
        $groupTag = factory(GroupTag::class)->create(['id' => 2]);
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
        $groupTags = factory(GroupTag::class, 15)->create();
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
        $groupTagCategory = factory(GroupTagCategory::class)->create(['reference' => 'ref1']);
        $groupTag = factory(GroupTag::class)->create(['reference' => 'ref2', 'tag_category_id' => $groupTagCategory->id]);

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
        $groupTag = factory(GroupTag::class)->create();
        $groupTagRepo = new \BristolSU\ControlDB\Repositories\Tags\GroupTag();
        $groupTagRepo->delete($groupTag->id());

        $groupTag->refresh();
        $this->assertTrue($groupTag->trashed());
    }

    /** @test */
    public function allThroughTagCategory_returns_all_tags_through_a_tag_category(){
        $category = factory(GroupTagCategory::class)->create();
        $tags = factory(GroupTag::class, 10)->create(['tag_category_id' => $category->id()]);
        factory(GroupTag::class, 10)->create();

        $groupTagRepo = new \BristolSU\ControlDB\Repositories\Tags\GroupTag();
        $tagsFromRepo = $groupTagRepo->allThroughTagCategory($category);
        $this->assertContainsOnlyInstancesOf(GroupTag::class, $tagsFromRepo);
        foreach($tags as $tag) {
            $this->assertTrue($tag->is(
                $tagsFromRepo->shift()
            ));
        }
    }

}
