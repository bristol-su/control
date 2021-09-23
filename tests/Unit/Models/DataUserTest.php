<?php

namespace BristolSU\Tests\ControlDB\Unit\Models;


use BristolSU\ControlDB\Models\DataRole;
use BristolSU\ControlDB\Models\DataUser;
use BristolSU\Tests\ControlDB\TestCase;
use Carbon\Carbon;

class DataUserTest extends TestCase
{
    
    /** @test */
    public function a_data_user_can_be_created(){
        $dob = Carbon::now()->subYears(22);
        
        $dataUser = DataUser::factory()->create([
            'first_name' => 'Toby',
            'last_name' => 'Twigger',
            'email' => 'email1@email.com',
            'dob' => $dob,
            'preferred_name' => 'TobyT'
        ]);
        
        $this->assertDatabaseHas('control_data_user', [
            'first_name' => 'Toby',
            'last_name' => 'Twigger',
            'email' => 'email1@email.com',
            'dob' => $dob,
            'preferred_name' => 'TobyT'
        ]);
        
    }

    /** @test */
    public function an_empty_data_user_can_be_created(){
        $dataUser = DataUser::factory()->create([
            'first_name' => null,
            'last_name' => null,
            'email' => null,
            'dob' => null,
            'preferred_name' => null
        ]);

        $this->assertDatabaseHas('control_data_user', [
            'id' => $dataUser->id,
            'first_name' => null,
            'last_name' => null,
            'email' => null,
            'dob' => null,
            'preferred_name' => null
        ]);

    }

    /** @test */
    public function an_id_can_be_retrieved_from_the_model()
    {
        $dataUser = DataUser::factory()->create([
            'id' => 4
        ]);

        $this->assertEquals(4, $dataUser->id());
    }

    /** @test */
    public function a_first_name_can_be_retrieved_from_the_model()
    {
        $dataUser = DataUser::factory()->create([
            'first_name' => 'Toby'
        ]);

        $this->assertEquals('Toby', $dataUser->firstName());
    }

    /** @test */
    public function a_last_name_can_be_retrieved_from_the_model()
    {
        $dataUser = DataUser::factory()->create([
            'last_name' => 'Twigger'
        ]);

        $this->assertEquals('Twigger', $dataUser->lastName());
    }

    /** @test */
    public function a_preferred_name_can_be_retrieved_from_the_model()
    {
        $dataUser = DataUser::factory()->create([
            'preferred_name' => 'TobyT'
        ]);

        $this->assertEquals('TobyT', $dataUser->preferredName());
    }

    /** @test */
    public function an_email_can_be_retrieved_from_the_model()
    {
        $dataUser = DataUser::factory()->create([
            'email' => 'email@email.com'
        ]);

        $this->assertEquals('email@email.com', $dataUser->email());
    }

    /** @test */
    public function a_dob_can_be_retrieved_from_the_model()
    {
        $dob = Carbon::create(1902, 12, 22, 00, 00, 00);
        $dataUser = DataUser::factory()->create([
            'dob' => $dob
        ]);

        $this->assertTrue($dob->equalTo($dataUser->dob()));
    }

    /** @test */
    public function a_first_name_can_be_set_on_the_model()
    {
        $dataUser = DataUser::factory()->create([
            'first_name' => 'Toby'
        ]);

        $dataUser->setFirstName('Martha');
        
        $this->assertEquals('Martha', $dataUser->firstName());
    }

    /** @test */
    public function a_last_name_can_be_set_on_the_model()
    {
        $dataUser = DataUser::factory()->create([
            'last_name' => 'Twigger'
        ]);

        $dataUser->setLastName('Jones');

        $this->assertEquals('Jones', $dataUser->lastName());
    }

    /** @test */
    public function a_preferred_name_can_be_set_on_the_model()
    {
        $dataUser = DataUser::factory()->create([
            'preferred_name' => 'TobyT'
        ]);

        $dataUser->setPreferredName('MJ');

        
        $this->assertEquals('MJ', $dataUser->preferredName());
    }

    /** @test */
    public function an_email_can_be_set_on_the_model()
    {
        $dataUser = DataUser::factory()->create([
            'email' => 'email@email.com'
        ]);
        
        $dataUser->setEmail('newemail@email.com');

        $this->assertEquals('newemail@email.com', $dataUser->email());
    }

    /** @test */
    public function a_dob_can_be_set_on_the_model()
    {
        $dob = Carbon::now()->subYears(22);
        $dataUser = DataUser::factory()->create([
            'dob' => Carbon::now()
        ]);

        $dataUser->setDob($dob);
        
        $this->assertEquals($dob->format('Y-m-d'), $dataUser->dob()->format('Y-m-d'));
    }

    /** @test */
    public function additional_properties_can_be_set_and_got(){
        DataUser::addProperty('student_id');
        $dataUser = DataUser::factory()->create();

        $dataUser->student_id = 'xy12345';
        $dataUser->save();

        $this->assertEquals('xy12345', $dataUser->student_id);
    }

    /** @test */
    public function additional_properties_are_saved_in_the_database(){
        DataUser::addProperty('student_id');
        $dataUser = DataUser::factory()->create();

        $dataUser->student_id = 'xy12345';
        $dataUser->save();

        $this->assertDatabaseHas('control_data_user', [
            'id' => $dataUser->id(),
            'additional_attributes' => '{"student_id":"xy12345"}'
        ]);
    }

    /** @test */
    public function additional_properties_are_appended_to_an_array(){
        DataUser::addProperty('student_id');
        $dataUser = DataUser::factory()->create();

        $dataUser->student_id = 'XY12345';
        $dataUser->save();

        $attributes = $dataUser->toArray();
        $this->assertArrayHasKey('id', $attributes);
        $this->assertArrayHasKey('student_id', $attributes);
        $this->assertEquals($dataUser->id(), $attributes['id']);
        $this->assertEquals('XY12345', $attributes['student_id']);
    }
}
