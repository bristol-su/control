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
        $userTag = factory(UserTag::class)->create(['id' => 2]);
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
        $userTags = factory(UserTag::class, 15)->create();
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
        $userTagCategory = factory(UserTagCategory::class)->create(['reference' => 'ref1']);
        $userTag = factory(UserTag::class)->create(['reference' => 'ref2', 'tag_category_id' => $userTagCategory]);

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
        $userTag = factory(UserTag::class)->create();
        $userTagRepo = new \BristolSU\ControlDB\Repositories\Tags\UserTag();
        $userTagRepo->delete($userTag->id());

        $userTag->refresh();
        $this->assertTrue($userTag->trashed());
    }
}
