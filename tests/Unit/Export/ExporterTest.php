<?php

namespace BristolSU\Tests\ControlDB\Unit\Export;

use BristolSU\ControlDB\Export\Exporter;
use BristolSU\ControlDB\Export\ExportManager;
use BristolSU\Tests\ControlDB\TestCase;

class ExporterTest extends TestCase
{

    /** @test */
    public function it_calls_a_method_on_the_underlying_instance(){
        $config = ['one', 'two'];
        $instance = $this->prophesize(ExportManager::class);
        $instance->withFormatter('formatter', $config)->shouldBeCalled();
        $this->instance('control-exporter', $instance->reveal());
        
        Exporter::withFormatter('formatter', $config);
    }
    
}