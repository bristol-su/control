<?php

namespace BristolSU\Tests\ControlDB\Unit\Traits;

use BristolSU\ControlDB\Models\DataRole;
use BristolSU\ControlDB\Models\Role;
use BristolSU\Tests\ControlDB\TestCase;

class DataRoleTraitTest extends TestCase
{
    /** @test */
    public function role_returns_the_role(){
        $dataRole = factory(DataRole::class)->create();
        $role = factory(Role::class)->create(['data_provider_id' => $dataRole->id()]);

        $this->assertInstanceOf(Role::class, $dataRole->role());
        $this->assertTrue($role->is($dataRole->role()));
    }

    /** @test */
    public function it_returns_null_if_no_role_found(){
        $dataRole = factory(DataRole::class)->create();
        $this->assertNull($dataRole->role());
    }
}