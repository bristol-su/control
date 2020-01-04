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
        $roleTag = factory(RoleTag::class)->create(['reference' => 'ref2']);

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


}
