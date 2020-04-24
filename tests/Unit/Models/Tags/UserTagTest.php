<?php


namespace BristolSU\Tests\ControlDB\Unit\Models\Tags;


use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\ControlDB\Models\Tags\GroupTagCategory;
use BristolSU\ControlDB\Models\Tags\UserTag;
use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\ControlDB\Models\Tags\UserTagCategory;
use BristolSU\Tests\ControlDB\TestCase;

class UserTagTest extends TestCase
{

    /** @test */
    public function it_has_an_id_attribute(){
        $userTag = factory(UserTag::class)->create(['id' => 1]);
        $this->assertEquals(1, $userTag->id());
    }

    /** @test */
    public function it_has_a_name_attribute(){
        $userTag = factory(UserTag::class)->create(['name' => 'Tag Name']);
        $this->assertEquals('Tag Name', $userTag->name());
    }

    /** @test */
    public function it_has_a_description_attribute(){
        $userTag = factory(UserTag::class)->create(['description' => 'Tag Description']);
        $this->assertEquals('Tag Description', $userTag->description());
    }

    /** @test */
    public function it_has_a_reference_attribute(){
        $userTag = factory(UserTag::class)->create(['reference' => 'tag_reference']);
        $this->assertEquals('tag_reference', $userTag->reference());
    }

    /** @test */
    public function it_has_a_category_id_attribute(){
        $userTag = factory(UserTag::class)->create(['tag_category_id' => 1]);
        $this->assertEquals(1, $userTag->categoryId());$tags = factory(UserTag::class)->create();
    }

    /** @test */
    public function it_sets_a_name_attribute(){
        $userTag = factory(UserTag::class)->create(['name' => 'Tag Name']);
        $userTag->setName('Tag Name2');
        $this->assertEquals('Tag Name2', $userTag->name());
    }

    /** @test */
    public function it_sets_a_description_attribute(){
        $userTag = factory(UserTag::class)->create(['description' => 'Tag Description']);
        $userTag->setDescription('Tag Description2');
        $this->assertEquals('Tag Description2', $userTag->description());
    }

    /** @test */
    public function it_sets_a_reference_attribute(){
        $userTag = factory(UserTag::class)->create(['reference' => 'tag_reference']);
        $userTag->setReference('tag_reference2');
        $this->assertEquals('tag_reference2', $userTag->reference());
    }

    /** @test */
    public function it_sets_a_category_id_attribute(){
        $tagCategory1 = factory(UserTagCategory::class)->create();
        $tagCategory2 = factory(UserTagCategory::class)->create();
        $userTag = factory(UserTag::class)->create(['tag_category_id' => $tagCategory1->id]);
        $userTag->setTagCategoryId($tagCategory2->id);
        $this->assertEquals($tagCategory2->id, $userTag->categoryId());
    }

    /** @test */
    public function it_applies_the_scope(){
        $tags = factory(UserTag::class, 5)->create();
        factory(RoleTag::class)->create();

        $resolvedTags = UserTag::all();
        $this->assertEquals(5, $resolvedTags->count());
        foreach($tags as $tag) {
            $this->assertTrue($tag->is($resolvedTags->shift()));
        }
    }

    /** @test */
    public function it_appends_the_full_reference_to_the_tag(){
        $tagCategory = factory(UserTagCategory::class)->create(['reference' => 'cat_ref']);
        $tag = factory(UserTag::class)->create(['reference' => 'tag_ref', 'tag_category_id' => $tagCategory->id]);

        $array =  $tag->toArray();

        $this->assertArrayHasKey('full_reference', $array);
        $this->assertEquals('cat_ref.tag_ref', $array['full_reference']);
    }
}
