<?php

namespace BristolSU\Tests\ControlDB\Unit\Export;

use BristolSU\ControlDB\Export\ExportManager;
use BristolSU\ControlDB\Export\Handler\DumpHandler;
use BristolSU\ControlDB\Export\Handler\Handler;
use BristolSU\ControlDB\Export\Handler\SaveCsvHandler;
use BristolSU\Tests\ControlDB\TestCase;
use Exception;
use Illuminate\Contracts\Container\Container;
use PHPUnit\Framework\Assert;

class ExportManagerTest extends TestCase
{

    /** @test */
    public function driver_throws_an_exception_if_the_config_is_not_found(){
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Exporter [test-setup] is not defined.');
        
        $exportManager = new ExportManager($this->app);
        $exportManager->driver('test-setup');
    }
    
    /** @test */
    public function driver_throws_an_exception_if_the_driver_cannot_be_created(){
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Driver [test-driver] is not supported.');
        
        $this->app['config']->set('control.export.test-setup', [
            'driver' => 'test-driver'
        ]);

        $exportManager = new ExportManager($this->app);
        $exportManager->driver('test-setup');
    }
    
    /** @test */
    public function a_custom_driver_function_is_invoked_if_manager_is_extended(){
        $handler = $this->prophesize(Handler::class);
        
        $this->app['config']->set('control.export.test-setup', [
            'driver' => 'test-driver',
            'setting' => 'Val1'
        ]);

        $exportManager = new ExportManager($this->app);
        
        $exportManager->extend('test-driver', function($app, $config) use ($handler) {
            Assert::assertInstanceOf(Container::class, $app);
            Assert::assertIsArray($config);
            Assert::assertEquals([
                'driver' => 'test-driver',
                'setting' => 'Val1',
                'formatters' => []
            ], $config);
            return $handler->reveal();
        });
        $resolvedDriver = $exportManager->driver('test-setup');
        $this->assertEquals($handler->reveal(), $resolvedDriver);
    }
    
     /** @test */
     public function a_driver_function_is_called_if_the_manager_knows_how_to_create_the_driver(){
         $handler = $this->prophesize(Handler::class);

         $this->app['config']->set('control.export.test-setup', [
             'driver' => 'test',
             'setting' => 'Val1'
         ]);

         $exportManager = new TestExportManager($this->app);
         $exportManager->setTestDriverResult($handler->reveal());
         
         $resolvedDriver = $exportManager->driver('test-setup');
         $this->assertEquals($handler->reveal(), $resolvedDriver);
     }
     
     /** @test */
     public function additional_formatters_are_added_to_the_config(){
         $handler = $this->prophesize(Handler::class);

         $this->app['config']->set('control.export.test-setup', [
             'driver' => 'test-driver',
             'setting' => 'Val1',
             'formatters' => [
                 'key1' => ['abc' => 'val1'],
                 'key2' => ['key3' => 'val2'],
             ]
         ]);

         $exportManager = new ExportManager($this->app);
         $exportManager->withFormatter('key3', ['akey' => 'aval', 'akey1' => 'aval1']);
         
         $exportManager->extend('test-driver', function($app, $config) use ($handler) {
             Assert::assertInstanceOf(Container::class, $app);
             Assert::assertIsArray($config);
             Assert::assertEquals([
                 'driver' => 'test-driver',
                 'setting' => 'Val1',
                 'formatters' => [
                     'key1' => ['abc' => 'val1'],
                     'key2' => ['key3' => 'val2'],
                     'key3' => ['akey' => 'aval', 'akey1' => 'aval1'],
                 ]
             ], $config);
             return $handler->reveal();
         });
         $exportManager->driver('test-setup');
     }
     
     /** @test */
     public function additional_formatters_are_added_to_the_config_if_no_formatters_exist_so_far(){
         $handler = $this->prophesize(Handler::class);

         $this->app['config']->set('control.export.test-setup', [
             'driver' => 'test-driver',
             'setting' => 'Val1',
         ]);

         $exportManager = new ExportManager($this->app);
         $exportManager->withFormatter('key3', ['akey' => 'aval', 'akey1' => 'aval1']);

         $exportManager->extend('test-driver', function($app, $config) use ($handler) {
             Assert::assertInstanceOf(Container::class, $app);
             Assert::assertIsArray($config);
             Assert::assertEquals([
                 'driver' => 'test-driver',
                 'setting' => 'Val1',
                 'formatters' => [
                     'key3' => ['akey' => 'aval', 'akey1' => 'aval1'],
                 ]
             ], $config);
             return $handler->reveal();
         });
         $exportManager->driver('test-setup');
     }
     
     /** @test */
     public function it_returns_the_default_driver_if_no_driver_given(){
         $handler = $this->prophesize(Handler::class);

         $this->app['config']->set('control.export.test-setup', [
             'driver' => 'test',
             'setting' => 'Val1'
         ]);
         
         $this->app['config']->set('control.export.default', 'test-setup');

         $exportManager = new TestExportManager($this->app);
         $exportManager->setTestDriverResult($handler->reveal());

         $resolvedDriver = $exportManager->driver();
         $this->assertEquals($handler->reveal(), $resolvedDriver);
     }
     
     /** @test */
     public function it_calls_the_function_on_the_driver_if_function_called_directly(){
         $items = ['one', 'two'];
         $handler = $this->prophesize(Handler::class);
         $handler->export($items)->shouldBeCalled();
         
         $this->app['config']->set('control.export.test-setup', [
             'driver' => 'test',
             'setting' => 'Val1'
         ]);

         $this->app['config']->set('control.export.default', 'test-setup');

         $exportManager = new TestExportManager($this->app);
         $exportManager->setTestDriverResult($handler->reveal());

         $exportManager->export($items);
     }
     
     /** @test */
     public function it_can_create_a_dump_driver(){
         $this->app['config']->set('control.export.test-setup', [
             'driver' => 'dump'
         ]);

         $exportManager = new ExportManager($this->app);
         $driver = $exportManager->driver('test-setup');
         $this->assertInstanceOf(DumpHandler::class, $driver);
     }
     
     /** @test */
     public function it_can_create_a_save_csv_driver(){
         $this->app['config']->set('control.export.test-setup', [
             'driver' => 'save-csv'
         ]);

         $exportManager = new ExportManager($this->app);
         $driver = $exportManager->driver('test-setup');
         $this->assertInstanceOf(SaveCsvHandler::class, $driver);
     }
     
}

class TestExportManager extends ExportManager
{
    protected $result;
    
    public function setTestDriverResult($result)
    {
        $this->result = $result;
    }
    
    public function createTestDriver()
    {
        return $this->result;
    }
}