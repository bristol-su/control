<?php

namespace BristolSU\Tests\ControlDB\Unit\Models\Tags;

use BristolSU\ControlDB\Models\Tags\UserTagCategory;
use BristolSU\ControlDB\Models\Tags\RoleTagCategory;
use BristolSU\Tests\ControlDB\TestCase;

class UserTagCategoryTest extends TestCase
{
    /** @test */
    public function it_creates_a_tag_category_with_a_type_of_user(){
        $category = factory(UserTagCategory::class)->create();
        $this->assertDatabaseHas('control_tag_categories', [
            'id' => $category->id(),
            'type' => 'user'
        ]);
    }

    /** @test */
    public function it_only_retrieves_user_tag_categories(){
        $tags = factory(UserTagCategory::class, 5)->create();
        factory(RoleTagCategory::class)->create();

        $resolvedTags = UserTagCategory::all();
        $this->assertEquals(5, $resolvedTags->count());
        foreach($tags as $tag) {
            $this->assertTrue($tag->is($resolvedTags->shift()));
        }
    }

    /** @test */
    public function id_returns_the_id(){
        $category = factory(UserTagCategory::class)->create(['id' => 1]);
        $this->assertEquals(1, $category->id());
    }

    /** @test */
    public function name_returns_the_name(){
        $category = factory(UserTagCategory::class)->create(['name' => 'name1']);
        $this->assertEquals('name1', $category->name());
    }

    /** @test */
    public function description_returns_the_description(){
        $category = factory(UserTagCategory::class)->create(['description' => 'Description']);
        $this->assertEquals('Description', $category->description());
    }

    /** @test */
    public function reference_returns_the_reference(){
        $category = factory(UserTagCategory::class)->create(['reference' => 'Reference']);
        $this->assertEquals('Reference', $category->reference());
    }

    /** @test */
    public function set_name_sets_the_name(){
        $category = factory(UserTagCategory::class)->create(['name' => 'name1']);
        $category->setName('NewName');
        $this->assertEquals('NewName', $category->name());
    }

    /** @test */
    public function set_description_sets_the_description(){
        $category = factory(UserTagCategory::class)->create(['description' => 'description1']);
        $category->setDescription('NewDescription');
        $this->assertEquals('NewDescription', $category->description());
    }

    /** @test */
    public function set_reference_sets_the_reference(){
        $category = factory(UserTagCategory::class)->create(['reference' => 'reference1']);
        $category->setReference('NewReference');
        $this->assertEquals('NewReference', $category->reference());
    }

}
