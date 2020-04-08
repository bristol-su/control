<?php

namespace BristolSU\Tests\ControlDB\Unit\Export\Formatter\Role;

use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserRole;
use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Role\AddRoleHoldersAsNewItems;
use BristolSU\ControlDB\Models\DataUser;
use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;

class AddRoleHoldersAsNewItemsTest extends TestCase
{

    /** @test */
    public function it_adds_role_holders_as_new_items()
    {
        $dataUser1 = factory(DataUser::class)->create(['first_name' => 'User1', 'last_name' => 'UserLast1', 'preferred_name' => 'UserPreferred1', 'email' => 'user1@example.com']);
        $dataUser2 = factory(DataUser::class)->create(['first_name' => 'User2', 'last_name' => 'UserLast2', 'preferred_name' => 'UserPreferred2', 'email' => 'user2@example.com']);
        $dataUser3 = factory(DataUser::class)->create(['first_name' => 'User3', 'last_name' => 'UserLast3', 'preferred_name' => 'UserPreferred3', 'email' => 'user3@example.com']);
        $user1 = factory(User::class)->create(['data_provider_id' => $dataUser1->id()]);
        $user2 = factory(User::class)->create(['data_provider_id' => $dataUser2->id()]);
        $user3 = factory(User::class)->create(['data_provider_id' => $dataUser3->id()]);
        $role1 = factory(Role::class)->create();
        $role2 = factory(Role::class)->create();
        app(UserRole::class)->addUserToRole($user1, $role1);
        app(UserRole::class)->addUserToRole($user2, $role2);
        app(UserRole::class)->addUserToRole($user3, $role2);
        app(UserRole::class)->addUserToRole($user3, $role1);

        $formatter = new AddRoleHoldersAsNewItems([]);
        $items = $formatter->format([
            FormattedItem::create($role1),
            FormattedItem::create($role2)
        ]);

        $this->assertCount(4, $items);
        $this->assertEquals([
            'User ID' => $user1->id(), 'User First Name' => 'User1', 'User Last Name' => 'UserLast1', 'User Preferred Name' => 'UserPreferred1', 'User Email' => 'user1@example.com'
        ], $items[0]->preparedItems());
        $this->assertEquals([
            'User ID' => $user3->id(), 'User First Name' => 'User3', 'User Last Name' => 'UserLast3', 'User Preferred Name' => 'UserPreferred3', 'User Email' => 'user3@example.com'
        ], $items[1]->preparedItems());
        $this->assertEquals([
            'User ID' => $user2->id(), 'User First Name' => 'User2', 'User Last Name' => 'UserLast2', 'User Preferred Name' => 'UserPreferred2', 'User Email' => 'user2@example.com'
        ], $items[2]->preparedItems());
        $this->assertEquals([
            'User ID' => $user3->id(), 'User First Name' => 'User3', 'User Last Name' => 'UserLast3', 'User Preferred Name' => 'UserPreferred3', 'User Email' => 'user3@example.com'
        ], $items[3]->preparedItems());
    }

}