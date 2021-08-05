<?php

namespace BristolSU\Tests\ControlDB\Unit\Export\Formatter\User;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\User\SimpleUserFormatter;
use BristolSU\ControlDB\Models\DataUser;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;
use Carbon\Carbon;

class SimpleUserFormatterTest extends TestCase
{

    /** @test */
    public function it_appends_the_user_information(){
        $birthday = Carbon::create(1997, 02, 14);
        $dataUser1 = DataUser::factory()->create(['first_name' => 'User1', 'last_name' => 'UserLast1', 'preferred_name' => 'UserPreferred1', 'email' => 'user1@example.com', 'dob' => $birthday->format('Y-m-d')]);
        $dataUser2 = DataUser::factory()->create(['first_name' => 'User2', 'last_name' => 'UserLast2', 'preferred_name' => 'UserPreferred2', 'email' => 'user2@example.com', 'dob' => $birthday->format('Y-m-d')]);
        $dataUser3 = DataUser::factory()->create(['first_name' => 'User3', 'last_name' => 'UserLast3', 'preferred_name' => 'UserPreferred3', 'email' => 'user3@example.com', 'dob' => $birthday->format('Y-m-d')]);
        $user1 = User::factory()->create(['data_provider_id' => $dataUser1->id()]);
        $user2 = User::factory()->create(['data_provider_id' => $dataUser2->id()]);
        $user3 = User::factory()->create(['data_provider_id' => $dataUser3->id()]);

        $formatter = new SimpleUserFormatter([]);
        $items = $formatter->format([FormattedItem::create($user1), FormattedItem::create($user2), FormattedItem::create($user3)]);

        $this->assertCount(3, $items);
        $this->assertEquals([
            'User ID' => $user1->id(), 'User First Name' => 'User1', 'User Last Name' => 'UserLast1', 'User Preferred Name' => 'UserPreferred1', 'User Email' => 'user1@example.com', 'User DoB' => $birthday
        ], $items[0]->preparedItems());
        $this->assertEquals([
            'User ID' => $user2->id(), 'User First Name' => 'User2', 'User Last Name' => 'UserLast2', 'User Preferred Name' => 'UserPreferred2', 'User Email' => 'user2@example.com', 'User DoB' => $birthday
        ], $items[1]->preparedItems());
        $this->assertEquals([
            'User ID' => $user3->id(), 'User First Name' => 'User3', 'User Last Name' => 'UserLast3', 'User Preferred Name' => 'UserPreferred3', 'User Email' => 'user3@example.com', 'User DoB' => $birthday
        ], $items[2]->preparedItems());
    }
    
}
