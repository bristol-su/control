<?php


namespace BristolSU\Tests\ControlDB\Unit\Models\Tags;


use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\Tests\ControlDB\TestCase;

class GroupTagTest extends TestCase
{

    /** @test */
    public function it_has_an_id_attribute(){
        $groupTag = factory(GroupTag::class)->create(['id' => 1]);
        $this->assertEquals(1, $groupTag->id());
    }

    /** @test */
    public function it_has_a_name_attribute(){
        $groupTag = factory(GroupTag::class)->create(['name' => 'Tag Name']);
        $this->assertEquals('Tag Name', $groupTag->name());
    }

    /** @test */
    public function it_has_a_description_attribute(){
        $groupTag = factory(GroupTag::class)->create(['description' => 'Tag Description']);
        $this->assertEquals('Tag Description', $groupTag->description());
    }

    /** @test */
    public function it_has_a_reference_attribute(){
        $groupTag = factory(GroupTag::class)->create(['reference' => 'tag_reference']);
        $this->assertEquals('tag_reference', $groupTag->reference());
    }

    /** @test */
    public function it_has_a_category_id_attribute(){
        $groupTag = factory(GroupTag::class)->create(['tag_category_id' => 1]);
        $this->assertEquals(1, $groupTag->categoryId());$tags = factory(GroupTag::class)->create();
    }

    /** @test */
    public function it_sets_a_name_attribute(){
        $groupTag = factory(GroupTag::class)->create(['name' => 'Tag Name']);
        $groupTag->setName('Tag Name2');
        $this->assertEquals('Tag Name2', $groupTag->name());
    }

    /** @test */
    public function it_sets_a_description_attribute(){
        $groupTag = factory(GroupTag::class)->create(['description' => 'Tag Description']);
        $groupTag->setDescription('Tag Description2');
        $this->assertEquals('Tag Description2', $groupTag->description());
    }

    /** @test */
    public function it_sets_a_reference_attribute(){
        $groupTag = factory(GroupTag::class)->create(['reference' => 'tag_reference']);
        $groupTag->setReference('tag_reference2');
        $this->assertEquals('tag_reference2', $groupTag->reference());
    }

    /** @test */
    public function it_sets_a_category_id_attribute(){
        $groupTag = factory(GroupTag::class)->create(['tag_category_id' => 1]);
        $groupTag->setTagCategoryId(2);
        $this->assertEquals(2, $groupTag->categoryId());
    }

    /** @test */
    public function it_applies_the_scope(){
        $tags = factory(GroupTag::class, 5)->create();
        factory(RoleTag::class)->create();

        $resolvedTags = GroupTag::all();
        $this->assertEquals(5, $resolvedTags->count());
        foreach($tags as $tag) {
            $this->assertTrue($tag->is($resolvedTags->shift()));
        }
    }
}
