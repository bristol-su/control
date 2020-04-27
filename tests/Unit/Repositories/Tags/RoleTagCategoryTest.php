<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories\Tags;

use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\ControlDB\Models\Tags\RoleTagCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use BristolSU\Tests\ControlDB\TestCase;

class RoleTagCategoryTest extends TestCase
{

    /** @test */
    public function getById_returns_a_role_tag_category_model_with_the_corresponding_id(){
        $roleTagCategory = factory(RoleTagCategory::class)->create(['id' => 2]);
        $roleTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\RoleTagCategory();
        $this->assertTrue(
            $roleTagCategory->is($roleTagCategoryRepo->getById(2))
        );
    }

    /** @test */
    public function getById_throws_a_modelNotFoundException_if_role_tag_category_does_not_exist(){
        $this->expectException(ModelNotFoundException::class);
        $roleTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\RoleTagCategory();
        $roleTagCategoryRepo->getById(5);
    }

    /** @test */
    public function all_returns_all_role_tags_categories(){
        $roleTagCategories = factory(RoleTagCategory::class, 15)->create();
        $roleTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\RoleTagCategory();
        $allTagCategories = $roleTagCategoryRepo->all();
        $this->assertInstanceOf(Collection::class, $allTagCategories);
        foreach($roleTagCategories as $roleTagCategory) {
            $this->assertTrue($roleTagCategory->is(
                $allTagCategories->shift()
            ));
        }
    }

    /** @test */
    public function getByReference_returns_a_tag_category_given_the_full_reference(){
        $roleTagCategory = factory(RoleTagCategory::class)->create(['reference' => 'ref1']);

        $roleTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\RoleTagCategory();
        $roleTagCategoryFromRepo = $roleTagCategoryRepo->getByReference('ref1');
        $this->assertInstanceOf(RoleTagCategory::class, $roleTagCategoryFromRepo);
        $this->assertTrue($roleTagCategory->is($roleTagCategoryFromRepo));

    }

    /** @test */
    public function getByReference_throws_an_exception_if_role_tag_category_not_found(){
        $this->expectException(ModelNotFoundException::class);
        $roleTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\RoleTagCategory();
        $roleTagCategoryRepo->getByReference('notavalidref');
    }

    /** @test */
    public function create_creates_a_role_tag_category_model(){
        $roleTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\RoleTagCategory();
        $roleTagCategoryRepo->create('Name', 'Description', 'reference');

        $this->assertDatabaseHas('control_tag_categories', [
            'name' => 'Name',
            'description' => 'Description',
            'reference' => 'reference',
        ]);
    }

    /** @test */
    public function create_returns_a_role_tag_category_model(){
        $roleTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\RoleTagCategory();
        $roleTagCategory = $roleTagCategoryRepo->create('Name', 'Description', 'reference');

        $this->assertInstanceOf(RoleTagCategory::class, $roleTagCategory);
        $this->assertEquals('Name', $roleTagCategory->name());
        $this->assertEquals('Description', $roleTagCategory->description());
        $this->assertEquals('reference', $roleTagCategory->reference());
    }

    /** @test */
    public function delete_deletes_a_role_tag_category_model(){
        $roleTagCategory = factory(RoleTagCategory::class)->create();
        $roleTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\RoleTagCategory();
        $roleTagCategoryRepo->delete($roleTagCategory->id());

        $roleTagCategory->refresh();
        $this->assertTrue($roleTagCategory->trashed());
    }

    /** @test */
    public function update_updates_a_role_tag_category()
    {
        $roleTagCategory = factory(RoleTagCategory::class)->create([
            'name' => 'TagCategoryName',
            'description' => 'TagCategoryDesc',
            'reference' => 'ref',
        ]);
        $this->assertDatabaseHas('control_tag_categories', [
            'id' => $roleTagCategory->id(),
            'name' => 'TagCategoryName',
            'description' => 'TagCategoryDesc',
            'reference' => 'ref',
            'type' => 'role'
        ]);
        $repository = new \BristolSU\ControlDB\Repositories\Tags\RoleTagCategory();
        $repository->update($roleTagCategory->id(), 'TagCategoryName2',  'TagCategoryDesc2', 'ref2');
        $this->assertDatabaseMissing('control_tag_categories', [
            'id' => $roleTagCategory->id(),
            'name' => 'TagCategoryName',
            'description' => 'TagCategoryDesc',
            'reference' => 'ref',
            'type' => 'role'
        ]);
        $this->assertDatabaseHas('control_tag_categories', [
            'id' => $roleTagCategory->id(),
            'name' => 'TagCategoryName2',
            'description' => 'TagCategoryDesc2',
            'reference' => 'ref2',
            'type' => 'role'
        ]);

    }

    /** @test */
    public function update_returns_the_updated_role_tag_category()
    {
        $roleTagCategory = factory(RoleTagCategory::class)->create([
            'name' => 'TagCategoryName',
            'description' => 'TagCategoryDesc',
            'reference' => 'ref',
        ]);
        $this->assertEquals('TagCategoryName', $roleTagCategory->name());
        $this->assertEquals('TagCategoryDesc', $roleTagCategory->description());
        $this->assertEquals('ref', $roleTagCategory->reference());

        $repository = new \BristolSU\ControlDB\Repositories\Tags\RoleTagCategory();
        $updatedRoleTagCategory = $repository->update($roleTagCategory->id(), 'TagCategoryName2', 'TagCategoryDesc2', 'ref2');

        $this->assertEquals('TagCategoryName2', $updatedRoleTagCategory->name());
        $this->assertEquals('TagCategoryDesc2', $updatedRoleTagCategory->description());
        $this->assertEquals('ref2', $updatedRoleTagCategory->reference());

    }
}
