<?php

namespace BristolSU\Tests\ControlDB\Unit\Export;

use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;

class FormattedItemTest extends TestCase
{

    /** @test */
    public function the_original_model_is_accessible(){
        $role = Role::factory()->create();
        $item = new FormattedItem($role);
        
        $this->assertInstanceOf(Role::class, $item->original());
        $this->assertTrue($role->is($item->original()));
    }
    
    /** @test */
    public function the_simple_factory_creates_an_instance_of_the_formatted_item(){
        $role = Role::factory()->create();
        $item = FormattedItem::create($role);

        $this->assertInstanceOf(Role::class, $item->original());
        $this->assertTrue($role->is($item->original()));
    }
    
    /** @test */
    public function isType_returns_true_if_the_original_type_is_the_same_as_given(){
        $role = Role::factory()->create();
        $item = new FormattedItem($role);
        $this->assertTrue($item->isType(Role::class));
    }

    /** @test */
    public function isType_returns_false_if_the_original_type_is_different_to_the_given(){
        $role = Role::factory()->create();
        $item = new FormattedItem($role);
        $this->assertFalse($item->isType(User::class));
    }
    
    /** @test */
    public function rows_can_be_added_and_retrieved(){
        $role = Role::factory()->create();
        $item = new FormattedItem($role);

        $item->addRow('row1', 'Value 1');
        $item->addRow('Row 2', 'Value 2');
        $this->assertEquals([
            'row1' => 'Value 1',
            'Row 2' => 'Value 2'
        ], $item->preparedItems());
    }
    
    /** @test */
    public function getColumnNames_returns_the_column_names(){
        $role = Role::factory()->create();
        $item = new FormattedItem($role);

        $item->addRow('row1', 'Value 1');
        $item->addRow('Row 2', 'Value 2');
        $this->assertEquals(['row1', 'Row 2'], $item->getColumnNames());
    }
    
    /** @test */
    public function getItem_returns_the_value_of_a_column(){
        $role = Role::factory()->create();
        $item = new FormattedItem($role);

        $item->addRow('row1', 'Value 1');
        $item->addRow('Row 2', 'Value 2');
        $this->assertEquals('Value 2', $item->getItem('Row 2'));
    }

    /** @test */
    public function getItem_returns_the_default_value_if_the_column_is_not_given(){
        $role = Role::factory()->create();
        $item = new FormattedItem($role);

        $item->addRow('row1', 'Value 1');
        $item->addRow('Row 2', 'Value 2');
        $this->assertEquals('N/A', $item->getItem('Row 3', 'N/A'));
    }
    
    /** @test */
    public function toArray_returns_the_prepared_items_as_an_array(){
        $role = Role::factory()->create();
        $item = new FormattedItem($role);

        $item->addRow('row1', 'Value 1');
        $item->addRow('Row 2', 'Value 2');
        $this->assertEquals([
            'row1' => 'Value 1',
            'Row 2' => 'Value 2'
        ], $item->toArray());
    }

    /** @test */
    public function toJson_returns_the_prepared_items_as_a_json_string(){
        $role = Role::factory()->create();
        $item = new FormattedItem($role);

        $item->addRow('row1', 'Value 1');
        $item->addRow('Row 2', 'Value 2');
        $this->assertEquals(json_encode([
            'row1' => 'Value 1',
            'Row 2' => 'Value 2'
        ]), $item->toJson());
    }

    /** @test */
    public function __toString_returns_the_prepared_items_as_a_json_string(){
        $role = Role::factory()->create();
        $item = new FormattedItem($role);

        $item->addRow('row1', 'Value 1');
        $item->addRow('Row 2', 'Value 2');
        $this->assertEquals(json_encode([
            'row1' => 'Value 1',
            'Row 2' => 'Value 2'
        ]), (string) $item);
    }
    
}
