<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories\Tags;

use BristolSU\ControlDB\Models\User;
use BristolSU\ControlDB\Models\Tags\UserTag;
use BristolSU\ControlDB\Models\Tags\UserTagCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use BristolSU\Tests\ControlDB\TestCase;

class UserTagTest extends TestCase
{

    /** @test */
    public function getById_returns_a_user_tag_model_with_the_corresponding_id(){
        $userTag = UserTag::factory()->create(['id' => 2]);
        $userTagRepo = new \BristolSU\ControlDB\Repositories\Tags\UserTag();
        $this->assertTrue(
            $userTag->is($userTagRepo->getById(2))
        );
    }

    /** @test */
    public function getById_throws_a_modelNotFoundException_if_user_tag_does_not_exist(){
        $this->expectException(ModelNotFoundException::class);
        $userTagRepo = new \BristolSU\ControlDB\Repositories\Tags\UserTag();
        $userTagRepo->getById(5);
    }

    /** @test */
    public function all_returns_all_user_tags(){
        $userTags = UserTag::factory()->count(15)->create();
        $userTagRepo = new \BristolSU\ControlDB\Repositories\Tags\UserTag();
        $allTags = $userTagRepo->all();
        $this->assertInstanceOf(Collection::class, $allTags);
        foreach($userTags as $userTag) {
            $this->assertTrue($userTag->is(
                $allTags->shift()
            ));
        }
    }

    /** @test */
    public function getTagByFullReference_returns_a_tag_given_the_full_reference(){
        $userTagCategory = UserTagCategory::factory()->create(['reference' => 'ref1']);
        $userTag = UserTag::factory()->create(['reference' => 'ref2', 'tag_category_id' => $userTagCategory]);

        $userTagRepo = new \BristolSU\ControlDB\Repositories\Tags\UserTag();
        $userTagFromRepo = $userTagRepo->getTagByFullReference('ref1.ref2');
        $this->assertInstanceOf(UserTag::class, $userTagFromRepo);
        $this->assertTrue($userTag->is($userTagFromRepo));

    }

    /** @test */
    public function getTagByFullReference_throws_an_exception_if_user_tag_not_found(){
        $this->expectException(ModelNotFoundException::class);
        $userTagRepo = new \BristolSU\ControlDB\Repositories\Tags\UserTag();
        $userTagRepo->getTagByFullReference('nota.validref');
    }

    /** @test */
    public function create_creates_a_user_tag_model(){
        $userTagRepo = new \BristolSU\ControlDB\Repositories\Tags\UserTag();
        $userTagRepo->create('Name', 'Description', 'reference', 1);

        $this->assertDatabaseHas('control_tags', [
            'name' => 'Name',
            'description' => 'Description',
            'reference' => 'reference',
            'tag_category_id' => 1
        ]);
    }

    /** @test */
    public function create_returns_a_user_tag_model(){
        $userTagRepo = new \BristolSU\ControlDB\Repositories\Tags\UserTag();
        $userTag = $userTagRepo->create('Name', 'Description', 'reference', 1);

        $this->assertInstanceOf(UserTag::class, $userTag);
        $this->assertEquals('Name', $userTag->name());
        $this->assertEquals('Description', $userTag->description());
        $this->assertEquals('reference', $userTag->reference());
        $this->assertEquals(1, $userTag->categoryId());
    }

    /** @test */
    public function delete_deletes_a_user_tag_model(){
        $userTag = UserTag::factory()->create();
        $userTagRepo = new \BristolSU\ControlDB\Repositories\Tags\UserTag();
        $userTagRepo->delete($userTag->id());

        $userTag->refresh();
        $this->assertTrue($userTag->trashed());
    }

    /** @test */
    public function allThroughTagCategory_returns_all_tags_through_a_tag_category(){
        $category = UserTagCategory::factory()->create();
        $tags = UserTag::factory()->count(10)->create(['tag_category_id' => $category->id()]);
        UserTag::factory()->count(10)->create();

        $userTagRepo = new \BristolSU\ControlDB\Repositories\Tags\UserTag();
        $tagsFromRepo = $userTagRepo->allThroughTagCategory($category);
        $this->assertContainsOnlyInstancesOf(UserTag::class, $tagsFromRepo);
        foreach($tags as $tag) {
            $this->assertTrue($tag->is(
                $tagsFromRepo->shift()
            ));
        }
    }

    /** @test */
    public function update_updates_a_user_tag_category()
    {
        $oldTagCategory = UserTagCategory::factory()->create();
        $newTagCategory = UserTagCategory::factory()->create();
        $userTag = UserTag::factory()->create([
            'name' => 'TagName',
            'description' => 'TagDesc',
            'reference' => 'ref',
            'tag_category_id' => $oldTagCategory->id
        ]);
        $this->assertDatabaseHas('control_tags', [
            'id' => $userTag->id(),
            'name' => 'TagName',
            'description' => 'TagDesc',
            'reference' => 'ref',
            'tag_category_id' => (string) $oldTagCategory->id,
        ]);
        $repository = new \BristolSU\ControlDB\Repositories\Tags\UserTag();
        $repository->update($userTag->id(), 'TagName2',  'TagDesc2', 'ref2', $newTagCategory->id());
        $this->assertDatabaseMissing('control_tags', [
            'id' => $userTag->id(),
            'name' => 'TagName',
            'description' => 'TagDesc',
            'reference' => 'ref',
            'tag_category_id' => (string) $oldTagCategory->id,
        ]);
        $this->assertDatabaseHas('control_tags', [
            'id' => $userTag->id(),
            'name' => 'TagName2',
            'description' => 'TagDesc2',
            'reference' => 'ref2',
            'tag_category_id' => (string) $newTagCategory->id,
        ]);

    }

    /** @test */
    public function update_returns_the_updated_user_tag_category()
    {
        $oldTagCategory = UserTagCategory::factory()->create();
        $newTagCategory = UserTagCategory::factory()->create();
        $userTag = UserTag::factory()->create([
            'name' => 'TagCategoryName',
            'description' => 'TagCategoryDesc',
            'reference' => 'ref',
            'tag_category_id' => $oldTagCategory->id()
        ]);
        $this->assertEquals('TagCategoryName', $userTag->name());
        $this->assertEquals('TagCategoryDesc', $userTag->description());
        $this->assertEquals('ref', $userTag->reference());
        $this->assertEquals($oldTagCategory->id(), $userTag->categoryId());

        $repository = new \BristolSU\ControlDB\Repositories\Tags\UserTag();
        $updatedUserTag = $repository->update($userTag->id(), 'TagCategoryName2', 'TagCategoryDesc2', 'ref2', $newTagCategory->id());

        $this->assertEquals('TagCategoryName2', $updatedUserTag->name());
        $this->assertEquals('TagCategoryDesc2', $updatedUserTag->description());
        $this->assertEquals('ref2', $updatedUserTag->reference());
        $this->assertEquals($newTagCategory->id(), $updatedUserTag->categoryId());
    }
}
