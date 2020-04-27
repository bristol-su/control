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

    /** @test */
    public function setRoleName_updates_the_roleName()
    {
        $dataRole = factory(DataRole::class)->create(['email' => 'email@example.com']);
        $dataRoleRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataRole::class);
        $dataRoleRepo->update($dataRole->id(), 'NewRoleName', 'email@example.com')->shouldBeCalled()->willReturn($dataRole);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\DataRole::class, $dataRoleRepo->reveal());

        $dataRole->setRoleName('NewRoleName');
    }

    /** @test */
    public function setEmail_updates_the_email()
    {
        $dataRole = factory(DataRole::class)->create(['role_name' => 'roleName1']);
        $dataRoleRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataRole::class);
        $dataRoleRepo->update($dataRole->id(), 'roleName1', 'email2@example.com')->shouldBeCalled()->willReturn($dataRole);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\DataRole::class, $dataRoleRepo->reveal());

        $dataRole->setEmail('email2@example.com');
    }
}