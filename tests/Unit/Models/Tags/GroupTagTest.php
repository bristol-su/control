<?php


namespace BristolSU\Tests\ControlDB\Unit\Models\Tags;


use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\ControlDB\Models\Tags\GroupTagCategory;
use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\Tests\ControlDB\TestCase;

class GroupTagTest extends TestCase
{

    /** @test */
    public function it_has_an_id_attribute(){
        $groupTag = GroupTag::factory()->create(['id' => 1]);
        $this->assertEquals(1, $groupTag->id());
    }

    /** @test */
    public function it_has_a_name_attribute(){
        $groupTag = GroupTag::factory()->create(['name' => 'Tag Name']);
        $this->assertEquals('Tag Name', $groupTag->name());
    }

    /** @test */
    public function it_has_a_description_attribute(){
        $groupTag = GroupTag::factory()->create(['description' => 'Tag Description']);
        $this->assertEquals('Tag Description', $groupTag->description());
    }

    /** @test */
    public function it_has_a_reference_attribute(){
        $groupTag = GroupTag::factory()->create(['reference' => 'tag_reference']);
        $this->assertEquals('tag_reference', $groupTag->reference());
    }

    /** @test */
    public function it_has_a_category_id_attribute(){
        $groupTag = GroupTag::factory()->create(['tag_category_id' => 1]);
        $this->assertEquals(1, $groupTag->categoryId());$tags = GroupTag::factory()->create();
    }

    /** @test */
    public function it_sets_a_name_attribute(){
        $groupTag = GroupTag::factory()->create(['name' => 'Tag Name']);
        $groupTag->setName('Tag Name2');
        $this->assertEquals('Tag Name2', $groupTag->name());
    }

    /** @test */
    public function it_sets_a_description_attribute(){
        $groupTag = GroupTag::factory()->create(['description' => 'Tag Description']);
        $groupTag->setDescription('Tag Description2');
        $this->assertEquals('Tag Description2', $groupTag->description());
    }

    /** @test */
    public function it_sets_a_reference_attribute(){
        $groupTag = GroupTag::factory()->create(['reference' => 'tag_reference']);
        $groupTag->setReference('tag_reference2');
        $this->assertEquals('tag_reference2', $groupTag->reference());
    }

    /** @test */
    public function it_sets_a_category_id_attribute(){
        $tagCategory1 = GroupTagCategory::factory()->create();
        $tagCategory2 = GroupTagCategory::factory()->create();
        $groupTag = GroupTag::factory()->create(['tag_category_id' => $tagCategory1->id]);
        $groupTag->setTagCategoryId($tagCategory2->id);
        $this->assertEquals($tagCategory2->id, $groupTag->categoryId());
    }

    /** @test */
    public function it_applies_the_scope(){
        $tags = GroupTag::factory()->count(5)->create();
        RoleTag::factory()->create();

        $resolvedTags = GroupTag::all();
        $this->assertEquals(5, $resolvedTags->count());
        foreach($tags as $tag) {
            $this->assertTrue($tag->is($resolvedTags->shift()));
        }
    }

    /** @test */
    public function it_appends_the_full_reference_to_the_tag(){
        $tagCategory = GroupTagCategory::factory()->create(['reference' => 'cat_ref']);
        $tag = GroupTag::factory()->create(['reference' => 'tag_ref', 'tag_category_id' => $tagCategory->id]);

        $array =  $tag->toArray();

        $this->assertArrayHasKey('full_reference', $array);
        $this->assertEquals('cat_ref.tag_ref', $array['full_reference']);
    }
}
