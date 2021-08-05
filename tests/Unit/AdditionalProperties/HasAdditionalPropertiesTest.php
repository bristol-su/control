<?php

namespace BristolSU\Tests\ControlDB\Unit\AdditionalProperties;

use BristolSU\ControlDB\AdditionalProperties\AdditionalPropertyStore;
use BristolSU\ControlDB\AdditionalProperties\HasAdditionalProperties;
use BristolSU\ControlDB\Models\DataGroup;
use BristolSU\Tests\ControlDB\TestCase;
use Exception;
use ReflectionClass;

class HasAdditionalPropertiesTest extends TestCase
{

    /** @test */
    public function it_throws_an_exception_if_the_class_is_not_an_eloquent_model()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The HasAdditionalProperties trait must only be used in an Eloquent model');

        $model = new IsNotEloquentModel();
        $model->initializeHasAdditionalProperties();
    }

    /** @test */
    public function it_appends_any_registered_additional_properties_on_boot()
    {
        $store = $this->prophesize(AdditionalPropertyStore::class);
        $store->getProperties(HasAppendMethod::class)->shouldBeCalled()->willReturn(['property1', 'property2']);
        $this->instance(AdditionalPropertyStore::class, $store->reveal());

        $model = new HasAppendMethod();
        $model->initializeHasAdditionalProperties();

        $this->assertEquals(['property1', 'property2'], $model->appends);
    }

    /** @test */
    public function it_sets_the_additional_attributes_column_to_hidden_on_boot()
    {
        $model = new Model();

        $this->assertEquals(['additional_attributes'], $model->getHidden());
    }

    /** @test */
    public function the_column_name_is_in_the_casts_array()
    {
        $model = new Model();

        $this->assertContains('additional_attributes', $model->getCasts());
    }

    /** @test */
    public function addProperty_adds_a_property_with_the_correct_key()
    {
        $store = $this->prophesize(AdditionalPropertyStore::class);
        $store->addProperty(HasAppendMethod::class, 'property1')->shouldBeCalled();
        $store->addProperty(HasAppendMethod::class, 'property2')->shouldBeCalled();
        $this->instance(AdditionalPropertyStore::class, $store->reveal());

        HasAppendMethod::addProperty('property1');
        HasAppendMethod::addProperty('property2');
    }

    /** @test */
    public function the_trait_is_automatically_initialized_by_an_eloquent_model()
    {
        Model::addProperty('property1');
        Model::addProperty('property2');
        $model = new Model();

        $appendsProperty = (new ReflectionClass(Model::class))->getProperty('appends');
        $appendsProperty->setAccessible(true);
        $appends = $appendsProperty->getValue($model);

        $this->assertEquals(['property1', 'property2'], $appends);
    }

    /** @test */
    public function getAdditionalAttributes_gets_all_additional_attributes_registered()
    {
        Model::addProperty('property1');
        Model::addProperty('property2');

        $this->assertEquals([
            'property1', 'property2'
        ], Model::getAdditionalAttributes());
    }

    /** @test */
    public function appends_attributes_defined_in_the_model_are_kept()
    {
        ModelWithAppends::addProperty('property2');
        ModelWithAppends::addProperty('property3');
        $model = new ModelWithAppends();

        $appendsProperty = (new ReflectionClass(ModelWithAppends::class))->getProperty('appends');
        $appendsProperty->setAccessible(true);
        $appends = $appendsProperty->getValue($model);
        $this->assertEquals(['property1', 'property2', 'property3'], $appends);
    }

    /** @test */
    public function additional_attributes_is_an_empty_array_if_no_attributes_set_and_column_is_null()
    {
        $model = new Model();

        $this->assertEquals([], $model->additional_attributes);
    }

    /** @test */
    public function additional_attributes_is_casted_to_an_array_if_a_string()
    {
        Model::addProperty('property1');
        Model::addProperty('property2');
        $model = new Model();

        $additionalAttributes = ['property1' => 'value1', 'property2' => 'value2'];
        $model->setAttribute('additional_attributes', json_encode($additionalAttributes));
        $this->assertEquals($additionalAttributes, $model->additional_attributes);
    }

    /** @test */
    public function additional_attributes_is_returned_if_already_an_array()
    {
        Model::addProperty('property1');
        Model::addProperty('property2');
        $model = new Model();

        $additionalAttributes = ['property1' => 'value1', 'property2' => 'value2'];
        $model->setAttribute('additional_attributes', $additionalAttributes);
        $this->assertEquals($additionalAttributes, $model->additional_attributes);
    }

    /** @test */
    public function additional_attributes_is_an_empty_array_if_invalid_json()
    {
        $model = new Model();

        $additionalAttributes = 'q{"property1":"sdfvaslue1"s,sdf"psdfroperty2"sd:dfds"value2"s}';

        $model->setAttribute('additional_attributes', $additionalAttributes);
        $this->assertEquals([], $model->additional_attributes);
    }

    /** @test */
    public function getAdditionalAttribute_returns_null_if_attribute_not_found()
    {
        Model::addProperty('property1');
        Model::addProperty('property2');
        $model = new Model();
        $additionalAttributes = json_encode(['property1' => 'value1', 'property2' => 'value2']);
        $model->setAttribute('additional_attributes', $additionalAttributes);

        $this->assertNull($model->getAdditionalAttribute('property3'));
    }

    /** @test */
    public function getAdditionalAttribute_returns_the_attribute_if_attribute_found()
    {
        Model::addProperty('property1');
        Model::addProperty('property2');
        $model = new Model();
        $additionalAttributes = json_encode(['property1' => 'value1', 'property2' => 'value2']);
        $model->setAttribute('additional_attributes', $additionalAttributes);

        $this->assertEquals('value2', $model->getAdditionalAttribute('property2'));
    }

    /** @test */
    public function attributes_can_be_retrieved_using_model_magic_method()
    {
        Model::addProperty('property1');
        Model::addProperty('property2');
        $model = new Model();
        $additionalAttributes = json_encode(['property1' => 'value1', 'property2' => 'value2']);
        $model->setAttribute('additional_attributes', $additionalAttributes);

        $this->assertEquals('value2', $model->property2);
    }

    /** @test */
    public function setAdditionalAttribute_sets_the_additional_attribute()
    {
        Model::addProperty('property1');
        $model = new Model();
        $model->setAdditionalAttribute('property1', 'value1');

        $this->assertEquals('value1', $model->getAdditionalAttribute('property1'));
    }

    /** @test */
    public function multiple_additional_attributes_can_be_set()
    {
        Model::addProperty('property1');
        Model::addProperty('property2');
        $model = new Model();
        $model->setAdditionalAttribute('property1', 'value1');
        $model->setAdditionalAttribute('property2', 'value2');

        $this->assertEquals('value1', $model->getAdditionalAttribute('property1'));
        $this->assertEquals('value2', $model->getAdditionalAttribute('property2'));
    }

    /** @test */
    public function multiple_additional_attributes_can_be_set_whilst_the_model_has_other_attributes()
    {
        Model::addProperty('property1');
        Model::addProperty('property2');
        $model = new Model();
        $model->other1 = 'attribute1';
        $model->setAdditionalAttribute('property1', 'value1');
        $model->setAdditionalAttribute('property2', 'value2');

        $this->assertEquals('attribute1', $model->other1);
        $this->assertEquals('value1', $model->getAdditionalAttribute('property1'));
        $this->assertEquals('value2', $model->getAdditionalAttribute('property2'));
    }

    /** @test */
    public function attributes_can_be_set_using_model_magic_method()
    {
        Model::addProperty('property1');
        Model::addProperty('property2');
        $model = new Model();
        $model->other1 = 'attribute1';
        $model->property1 = 'value1';
        $model->property2 = 'value2';

        $this->assertEquals('attribute1', $model->other1);
        $this->assertEquals('value1', $model->getAdditionalAttribute('property1'));
        $this->assertEquals('value2', $model->getAdditionalAttribute('property2'));
    }

    /** @test */
    public function an_accessor_is_defined_for_any_property()
    {
        Model::addProperty('property1');
        $model = new Model();
        $model->setProperty1Attribute('value1');
        $this->assertEquals('value1', $model->getProperty1Attribute());
    }

    /** @test */
    public function the_parent_call_function_is_called_if_the_method_is_not_an_accessor_or_mutator()
    {
        $model = new Model();
        $this->assertEquals('TestHere', $model->someOther);
    }

    /** @test */
    public function saveAdditionalAttribute_sets_and_saves_an_additional_attribute()
    {
        DataGroup::addProperty('account');
        $dataGroup = DataGroup::factory()->create(['email' => 'abc@123.com']);
        $dataGroup->setAdditionalAttribute('account', 'AAA');
        $dataGroup->save();

        $this->assertDatabaseHas('control_data_group', [
            'email' => 'abc@123.com', 'additional_attributes' => json_encode(['account' => 'AAA'])
        ]);

        $dataGroup->saveAdditionalAttribute('account', 'BBB');

        $this->assertDatabaseHas('control_data_group', [
            'email' => 'abc@123.com', 'additional_attributes' => json_encode(['account' => 'BBB'])
        ]);

    }
}

class IsNotEloquentModel
{
    use HasAdditionalProperties;
}

class HasAppendMethod extends \Illuminate\Database\Eloquent\Model
{

    use HasAdditionalProperties;

    public $appends = [];

    public function append($property)
    {
        $this->appends = $property;
    }
}

class Model extends \Illuminate\Database\Eloquent\Model
{
    use HasAdditionalProperties;

    public function getSomeOtherAttribute()
    {
        return 'TestHere';
    }
}

class ModelWithAppends extends \Illuminate\Database\Eloquent\Model
{
    use HasAdditionalProperties;

    protected $appends = ['property1'];

}
