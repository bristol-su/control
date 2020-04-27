<?php

namespace BristolSU\Tests\ControlDB;

use BristolSU\ControlDB\ControlDBServiceProvider;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestResponse;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Prophecy\PhpUnit\ProphecyTrait;

abstract class TestCase extends BaseTestCase
{
    use DatabaseTransactions, ProphecyTrait;
    
    public $apiUrl = 'api/control';
    
    public function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom(realpath(__DIR__ . '/../database/migrations'));
        $this->withFactories(__DIR__ . '/../database/factories');
        $this->setupPagination();
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $app['config']->set('control.api_prefix', $this->apiUrl);
        $app['config']->set('control.api_middleware', ['api']);
    }

    /**
     * Load package service provider.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ControlDBServiceProvider::class,
        ];
    }

    private function setupPagination()
    {
        TestResponse::mixin(new TestResponseMixin());
    }
}
