<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories\Tags;

use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\ControlDB\Models\Tags\RoleTagCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use BristolSU\Tests\ControlDB\TestCase;

class RoleTagTest extends TestCase
{

    /** @test */
    public function getById_returns_a_role_tag_model_with_the_corresponding_id(){
        $roleTag = factory(RoleTag::class)->create(['id' => 2]);
        $roleTagRepo = new \BristolSU\ControlDB\Repositories\Tags\RoleTag();
        $this->assertTrue(
            $roleTag->is($roleTagRepo->getById(2))
        );
    }

    /** @test */
    public function getById_throws_a_modelNotFoundException_if_role_tag_does_not_exist(){
        $this->expectException(ModelNotFoundException::class);
        $roleTagRepo = new \BristolSU\ControlDB\Repositories\Tags\RoleTag();
        $roleTagRepo->getById(5);
    }

    /** @test */
    public function all_returns_all_role_tags(){
        $roleTags = factory(RoleTag::class, 15)->create();
        $roleTagRepo = new \BristolSU\ControlDB\Repositories\Tags\RoleTag();
        $allTags = $roleTagRepo->all();
        $this->assertInstanceOf(Collection::class, $allTags);
        foreach($roleTags as $roleTag) {
            $this->assertTrue($roleTag->is(
                $allTags->shift()
            ));
        }
    }

    /** @test */
    public function getTagByFullReference_returns_a_tag_given_the_full_reference(){
        $roleTagCategory = factory(RoleTagCategory::class)->create(['reference' => 'ref1']);
        $roleTag = factory(RoleTag::class)->create(['reference' => 'ref2', 'tag_category_id' => $roleTagCategory]);

        $roleTagRepo = new \BristolSU\ControlDB\Repositories\Tags\RoleTag();
        $roleTagFromRepo = $roleTagRepo->getTagByFullReference('ref1.ref2');
        $this->assertInstanceOf(RoleTag::class, $roleTagFromRepo);
        $this->assertTrue($roleTag->is($roleTagFromRepo));

    }

    /** @test */
    public function getTagByFullReference_throws_an_exception_if_role_tag_not_found(){
        $this->expectException(ModelNotFoundException::class);
        $roleTagRepo = new \BristolSU\ControlDB\Repositories\Tags\RoleTag();
        $roleTagRepo->getTagByFullReference('nota.validref');
    }

    /** @test */
    public function create_creates_a_role_tag_model(){
        $roleTagRepo = new \BristolSU\ControlDB\Repositories\Tags\RoleTag();
        $roleTagRepo->create('Name', 'Description', 'reference', 1);

        $this->assertDatabaseHas('control_tags', [
            'name' => 'Name',
            'description' => 'Description',
            'reference' => 'reference',
            'tag_category_id' => 1
        ]);
    }

    /** @test */
    public function create_returns_a_role_tag_model(){
        $roleTagRepo = new \BristolSU\ControlDB\Repositories\Tags\RoleTag();
        $roleTag = $roleTagRepo->create('Name', 'Description', 'reference', 1);

        $this->assertInstanceOf(RoleTag::class, $roleTag);
        $this->assertEquals('Name', $roleTag->name());
        $this->assertEquals('Description', $roleTag->description());
        $this->assertEquals('reference', $roleTag->reference());
        $this->assertEquals(1, $roleTag->categoryId());
    }

    /** @test */
    public function delete_deletes_a_role_tag_model(){
        $roleTag = factory(RoleTag::class)->create();
        $roleTagRepo = new \BristolSU\ControlDB\Repositories\Tags\RoleTag();
        $roleTagRepo->delete($roleTag->id());

        $roleTag->refresh();
        $this->assertTrue($roleTag->trashed());
    }

    /** @test */
    public function allThroughTagCategory_returns_all_tags_through_a_tag_category(){
        $category = factory(RoleTagCategory::class)->create();
        $tags = factory(RoleTag::class, 10)->create(['tag_category_id' => $category->id()]);
        factory(RoleTag::class, 10)->create();

        $roleTagRepo = new \BristolSU\ControlDB\Repositories\Tags\RoleTag();
        $tagsFromRepo = $roleTagRepo->allThroughTagCategory($category);
        $this->assertContainsOnlyInstancesOf(RoleTag::class, $tagsFromRepo);
        foreach($tags as $tag) {
            $this->assertTrue($tag->is(
                $tagsFromRepo->shift()
            ));
        }
    }
}
