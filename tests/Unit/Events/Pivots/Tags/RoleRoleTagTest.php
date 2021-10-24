<?php

namespace BristolSU\Tests\ControlDB\Unit\Events\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\RoleRoleTag;
use BristolSU\ControlDB\Events\Pivots\Tags\RoleRoleTag\RoleRoleTagEventDispatcher;
use BristolSU\ControlDB\Events\Pivots\Tags\RoleRoleTag\RoleTagged;
use BristolSU\ControlDB\Events\Pivots\Tags\RoleRoleTag\RoleUntagged;
use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Facades\Event;
use Prophecy\Argument;

class RoleRoleTagTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        Event::fake();
    }

    /** @test */
    public function roleTagged_event_can_be_created_and_data_retrieved(){
        $role = Role::factory()->create();
        $roleTag = RoleTag::factory()->create();

        $event = new RoleTagged($role, $roleTag);

        $this->assertTrue($role->is($event->role));
        $this->assertTrue($roleTag->is($event->roleTag));
    }

    /** @test */
    public function roleUntagged_event_can_be_created_and_data_retrieved(){
        $role = Role::factory()->create();
        $roleTag = RoleTag::factory()->create();

        $event = new RoleUntagged($role, $roleTag);

        $this->assertTrue($role->is($event->role));
        $this->assertTrue($roleTag->is($event->roleTag));
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getTagsThroughRole(){
        $role = Role::factory()->create();
        $roleTags = RoleTag::factory()->count(10)->create();

        $baseRoleTagRoleRepo = $this->prophesize(RoleRoleTag::class);
        $baseRoleTagRoleRepo->getTagsThroughRole(Argument::that(fn($arg) => $arg instanceof Role && $arg->is($role)))
            ->shouldBeCalled()->willReturn($roleTags);

        $eventDispatcher = new RoleRoleTagEventDispatcher($baseRoleTagRoleRepo->reveal());
        $allRoleTags = $eventDispatcher->getTagsThroughRole($role);
        $this->assertCount(10, $allRoleTags);
        foreach($allRoleTags as $roleTag) {
            $this->assertTrue($roleTags->shift()->is($roleTag));
        }
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getRolesThroughTag(){
        $roles = Role::factory()->count(10)->create();
        $roleTag = RoleTag::factory()->create();

        $baseRoleRoleTagRepo = $this->prophesize(RoleRoleTag::class);
        $baseRoleRoleTagRepo->getRolesThroughTag(Argument::that(fn($arg) => $arg instanceof RoleTag && $arg->is($roleTag)))
            ->shouldBeCalled()->willReturn($roles);

        $eventDispatcher = new RoleRoleTagEventDispatcher($baseRoleRoleTagRepo->reveal());
        $allRoles = $eventDispatcher->getRolesThroughTag($roleTag);
        $this->assertCount(10, $allRoles);
        foreach($allRoles as $role) {
            $this->assertTrue($roles->shift()->is($role));
        }
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_addTagToRole_and_it_dispatches_an_event(){
        $role = Role::factory()->create();
        $roleTag = RoleTag::factory()->create();

        $baseRoleRoleTagRepo = $this->prophesize(RoleRoleTag::class);
        $baseRoleRoleTagRepo->addTagToRole(
            Argument::that(fn($arg) => $arg instanceof RoleTag && $arg->is($roleTag)),
            Argument::that(fn($arg) => $arg instanceof Role && $arg->is($role))
        )->shouldBeCalled();

        $eventDispatcher = new RoleRoleTagEventDispatcher($baseRoleRoleTagRepo->reveal());
        $eventDispatcher->addTagToRole($roleTag, $role);

        Event::assertDispatched(
            RoleTagged::class,
            fn(RoleTagged $event) => $roleTag->is($event->roleTag) && $role->is($event->role)
        );
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_removeTagFromRole_and_it_dispatches_an_event(){
        $role = Role::factory()->create();
        $roleTag = RoleTag::factory()->create();

        $baseRoleRoleTagRepo = $this->prophesize(RoleRoleTag::class);
        $baseRoleRoleTagRepo->removeTagFromRole(
            Argument::that(fn($arg) => $arg instanceof RoleTag && $arg->is($roleTag)),
            Argument::that(fn($arg) => $arg instanceof Role && $arg->is($role))
        )->shouldBeCalled();

        $eventDispatcher = new RoleRoleTagEventDispatcher($baseRoleRoleTagRepo->reveal());
        $eventDispatcher->removeTagFromRole($roleTag, $role);

        Event::assertDispatched(
            RoleUntagged::class,
            fn(RoleUntagged $event) => $roleTag->is($event->roleTag) && $role->is($event->role)
        );
    }

}
