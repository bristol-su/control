<?php

namespace BristolSU\Tests\ControlDB\Unit\Models;


use BristolSU\ControlDB\Models\DataGroup;
use BristolSU\ControlDB\Models\DataPosition;
use BristolSU\Tests\ControlDB\TestCase;

class DataPositionTest extends TestCase
{
    
    /** @test */
    public function a_data_position_can_be_created(){
        factory(DataPosition::class)->create([
            'name' => 'Position1',
            'description' => 'description1',
        ]);
        
        $this->assertDatabaseHas('control_data_position', [
            'name' => 'Position1',
            'description' => 'description1',
        ]);
        
    }

    /** @test */
    public function an_empty_data_position_can_be_created(){
        $dataPosition = factory(DataPosition::class)->create([
            'name' => null,
            'description' => null,
        ]);

        $this->assertDatabaseHas('control_data_position', [
            'id' => $dataPosition->id,
            'name' => null,
            'description' => null,
        ]);

    }

    /** @test */
    public function an_id_can_be_retrieved_from_the_model()
    {
        $dataPosition = factory(DataPosition::class)->create([
            'id' => 4
        ]);

        $this->assertEquals(4, $dataPosition->id());
    }

    /** @test */
    public function a_name_can_be_retrieved_from_the_model()
    {
        $dataPosition = factory(DataPosition::class)->create([
            'name' => 'Position1'
        ]);

        $this->assertEquals('Position1', $dataPosition->name());
    }

    /** @test */
    public function an_description_can_be_retrieved_from_the_model()
    {
        $dataPosition = factory(DataPosition::class)->create([
            'description' => 'description'
        ]);

        $this->assertEquals('description', $dataPosition->description());
    }

    /** @test */
    public function a_name_can_be_set_on_the_model()
    {
        $dataPosition = factory(DataPosition::class)->create([
            'name' => 'Position1'
        ]);

        $dataPosition->setName('Position2');
        
        $this->assertEquals('Position2', $dataPosition->name());
    }

    /** @test */
    public function an_description_can_be_set_on_the_model()
    {
        $dataPosition = factory(DataPosition::class)->create([
            'description' => 'description'
        ]);
        
        $dataPosition->setDescription('newdescription');

        $this->assertEquals('newdescription', $dataPosition->description());
    }

    /** @test */
    public function additional_properties_can_be_set_and_got(){
        DataPosition::addProperty('alias');
        $dataPosition = factory(DataPosition::class)->create([
            'name' => 'Secretary',
            'description' => 'someDescription'
        ]);

        $dataPosition->alias = 'Sec';
        $dataPosition->save();

        $this->assertEquals('Sec', $dataPosition->alias);
    }

    /** @test */
    public function additional_properties_are_saved_in_the_database(){
        DataPosition::addProperty('alias');
        $dataPosition = factory(DataPosition::class)->create([
            'name' => 'Secretary',
            'description' => 'someDescription'
        ]);

        $dataPosition->alias = 'Sec';
        $dataPosition->save();

        $this->assertDatabaseHas('control_data_position', [
            'name' => 'Secretary',
            'description' => 'someDescription',
            'additional_attributes' => '{"alias":"Sec"}'
        ]);
    }

    /** @test */
    public function additional_properties_are_appended_to_an_array(){
        DataPosition::addProperty('alias');
        $dataPosition = factory(DataPosition::class)->create([
            'name' => 'Secretary',
            'description' => 'someDescription'
        ]);

        $dataPosition->alias = 'Sec';
        $dataPosition->save();

        $attributes = $dataPosition->toArray();
        $this->assertArrayHasKey('name', $attributes);
        $this->assertArrayHasKey('description', $attributes);
        $this->assertArrayHasKey('alias', $attributes);
        $this->assertEquals('Secretary', $attributes['name']);
        $this->assertEquals('someDescription', $attributes['description']);
        $this->assertEquals('Sec', $attributes['alias']);
    }

}
