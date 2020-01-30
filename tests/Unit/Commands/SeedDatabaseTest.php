<?php


namespace BristolSU\Tests\ControlDB\Unit\Commands;


use BristolSU\ControlDB\Commands\SeedDatabase;
use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Position;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;

class SeedDatabaseTest extends TestCase
{

    /** @test */
    public function it_seeds_the_database(){
        $this->artisan(SeedDatabase::class);

        $this->assertEquals(100, User::all()->count());
        $this->assertEquals(50, Group::all()->count());
        $this->assertEquals(10, Position::all()->count());
    }
    
}