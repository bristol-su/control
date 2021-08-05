<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories\Tags;

use BristolSU\ControlDB\Models\User;
use BristolSU\ControlDB\Models\Tags\UserTag;
use BristolSU\ControlDB\Models\Tags\UserTagCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use BristolSU\Tests\ControlDB\TestCase;

class UserTagCategoryTest extends TestCase
{

    /** @test */
    public function getById_returns_a_user_tag_category_model_with_the_corresponding_id(){
        $userTagCategory = UserTagCategory::factory()->create(['id' => 2]);
        $userTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\UserTagCategory();
        $this->assertTrue(
            $userTagCategory->is($userTagCategoryRepo->getById(2))
        );
    }

    /** @test */
    public function getById_throws_a_modelNotFoundException_if_user_tag_category_does_not_exist(){
        $this->expectException(ModelNotFoundException::class);
        $userTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\UserTagCategory();
        $userTagCategoryRepo->getById(5);
    }

    /** @test */
    public function all_returns_all_user_tags_categories(){
        $userTagCategories = UserTagCategory::factory()->count(15)->create();
        $userTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\UserTagCategory();
        $allTagCategories = $userTagCategoryRepo->all();
        $this->assertInstanceOf(Collection::class, $allTagCategories);
        foreach($userTagCategories as $userTagCategory) {
            $this->assertTrue($userTagCategory->is(
                $allTagCategories->shift()
            ));
        }
    }

    /** @test */
    public function getByReference_returns_a_tag_category_given_the_full_reference(){
        $userTagCategory = UserTagCategory::factory()->create(['reference' => 'ref1']);

        $userTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\UserTagCategory();
        $userTagCategoryFromRepo = $userTagCategoryRepo->getByReference('ref1');
        $this->assertInstanceOf(UserTagCategory::class, $userTagCategoryFromRepo);
        $this->assertTrue($userTagCategory->is($userTagCategoryFromRepo));

    }

    /** @test */
    public function getByReference_throws_an_exception_if_user_tag_category_not_found(){
        $this->expectException(ModelNotFoundException::class);
        $userTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\UserTagCategory();
        $userTagCategoryRepo->getByReference('notavalidref');
    }

    /** @test */
    public function create_creates_a_user_tag_category_model(){
        $userTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\UserTagCategory();
        $userTagCategoryRepo->create('Name', 'Description', 'reference');

        $this->assertDatabaseHas('control_tag_categories', [
            'name' => 'Name',
            'description' => 'Description',
            'reference' => 'reference',
        ]);
    }

    /** @test */
    public function create_returns_a_user_tag_category_model(){
        $userTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\UserTagCategory();
        $userTagCategory = $userTagCategoryRepo->create('Name', 'Description', 'reference');

        $this->assertInstanceOf(UserTagCategory::class, $userTagCategory);
        $this->assertEquals('Name', $userTagCategory->name());
        $this->assertEquals('Description', $userTagCategory->description());
        $this->assertEquals('reference', $userTagCategory->reference());
    }

    /** @test */
    public function delete_deletes_a_user_tag_category_model(){
        $userTagCategory = UserTagCategory::factory()->create();
        $userTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\UserTagCategory();
        $userTagCategoryRepo->delete($userTagCategory->id());

        $userTagCategory->refresh();
        $this->assertTrue($userTagCategory->trashed());
    }

    /** @test */
    public function update_updates_a_user_tag_category()
    {
        $userTagCategory = UserTagCategory::factory()->create([
            'name' => 'TagCategoryName',
            'description' => 'TagCategoryDesc',
            'reference' => 'ref',
        ]);
        $this->assertDatabaseHas('control_tag_categories', [
            'id' => $userTagCategory->id(),
            'name' => 'TagCategoryName',
            'description' => 'TagCategoryDesc',
            'reference' => 'ref',
            'type' => 'user'
        ]);
        $repository = new \BristolSU\ControlDB\Repositories\Tags\UserTagCategory();
        $repository->update($userTagCategory->id(), 'TagCategoryName2',  'TagCategoryDesc2', 'ref2');
        $this->assertDatabaseMissing('control_tag_categories', [
            'id' => $userTagCategory->id(),
            'name' => 'TagCategoryName',
            'description' => 'TagCategoryDesc',
            'reference' => 'ref',
            'type' => 'user'
        ]);
        $this->assertDatabaseHas('control_tag_categories', [
            'id' => $userTagCategory->id(),
            'name' => 'TagCategoryName2',
            'description' => 'TagCategoryDesc2',
            'reference' => 'ref2',
            'type' => 'user'
        ]);

    }

    /** @test */
    public function update_returns_the_updated_user_tag_category()
    {
        $userTagCategory = UserTagCategory::factory()->create([
            'name' => 'TagCategoryName',
            'description' => 'TagCategoryDesc',
            'reference' => 'ref',
        ]);
        $this->assertEquals('TagCategoryName', $userTagCategory->name());
        $this->assertEquals('TagCategoryDesc', $userTagCategory->description());
        $this->assertEquals('ref', $userTagCategory->reference());

        $repository = new \BristolSU\ControlDB\Repositories\Tags\UserTagCategory();
        $updatedUserTagCategory = $repository->update($userTagCategory->id(), 'TagCategoryName2', 'TagCategoryDesc2', 'ref2');

        $this->assertEquals('TagCategoryName2', $updatedUserTagCategory->name());
        $this->assertEquals('TagCategoryDesc2', $updatedUserTagCategory->description());
        $this->assertEquals('ref2', $updatedUserTagCategory->reference());

    }

}
