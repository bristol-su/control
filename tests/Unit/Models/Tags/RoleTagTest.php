<?php


namespace BristolSU\Tests\ControlDB\Unit\Models\Tags;


use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\ControlDB\Models\Tags\GroupTagCategory;
use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\ControlDB\Models\Tags\RoleTagCategory;
use BristolSU\ControlDB\Models\Tags\UserTag;
use BristolSU\Tests\ControlDB\TestCase;

class RoleTagTest extends TestCase
{

    /** @test */
    public function it_has_an_id_attribute(){
        $roleTag = RoleTag::factory()->create(['id' => 1]);
        $this->assertEquals(1, $roleTag->id());
    }

    /** @test */
    public function it_has_a_name_attribute(){
        $roleTag = RoleTag::factory()->create(['name' => 'Tag Name']);
        $this->assertEquals('Tag Name', $roleTag->name());
    }

    /** @test */
    public function it_has_a_description_attribute(){
        $roleTag = RoleTag::factory()->create(['description' => 'Tag Description']);
        $this->assertEquals('Tag Description', $roleTag->description());
    }

    /** @test */
    public function it_has_a_reference_attribute(){
        $roleTag = RoleTag::factory()->create(['reference' => 'tag_reference']);
        $this->assertEquals('tag_reference', $roleTag->reference());
    }

    /** @test */
    public function it_has_a_category_id_attribute(){
        $roleTag = RoleTag::factory()->create(['tag_category_id' => 1]);
        $this->assertEquals(1, $roleTag->categoryId());$tags = RoleTag::factory()->create();
    }

    /** @test */
    public function it_sets_a_name_attribute(){
        $roleTag = RoleTag::factory()->create(['name' => 'Tag Name']);
        $roleTag->setName('Tag Name2');
        $this->assertEquals('Tag Name2', $roleTag->name());
    }

    /** @test */
    public function it_sets_a_description_attribute(){
        $roleTag = RoleTag::factory()->create(['description' => 'Tag Description']);
        $roleTag->setDescription('Tag Description2');
        $this->assertEquals('Tag Description2', $roleTag->description());
    }

    /** @test */
    public function it_sets_a_reference_attribute(){
        $roleTag = RoleTag::factory()->create(['reference' => 'tag_reference']);
        $roleTag->setReference('tag_reference2');
        $this->assertEquals('tag_reference2', $roleTag->reference());
    }

    /** @test */
    public function it_sets_a_category_id_attribute(){
        $tagCategory1 = RoleTagCategory::factory()->create();
        $tagCategory2 = RoleTagCategory::factory()->create();
        $roleTag = RoleTag::factory()->create(['tag_category_id' => $tagCategory1->id]);
        $roleTag->setTagCategoryId($tagCategory2->id);
        $this->assertEquals($tagCategory2->id, $roleTag->categoryId());
    }

    /** @test */
    public function it_applies_the_scope(){
        $tags = RoleTag::factory()->count(5)->create();
        UserTag::factory()->create();

        $resolvedTags = RoleTag::all();

        $this->assertEquals(5, $resolvedTags->count());
        foreach($tags as $tag) {
            $this->assertTrue($tag->is($resolvedTags->shift()));
        }
    }

    /** @test */
    public function it_appends_the_full_reference_to_the_tag(){
        $tagCategory = RoleTagCategory::factory()->create(['reference' => 'cat_ref']);
        $tag = RoleTag::factory()->create(['reference' => 'tag_ref', 'tag_category_id' => $tagCategory->id]);

        $array =  $tag->toArray();

        $this->assertArrayHasKey('full_reference', $array);
        $this->assertEquals('cat_ref.tag_ref', $array['full_reference']);
    }
}
