<?php

namespace BristolSU\ControlDB\Export;

use BristolSU\ControlDB\Export\Handler\Airtable\AirtableHandler;
use BristolSU\ControlDB\Export\Handler\DumpHandler;
use BristolSU\ControlDB\Export\Handler\Handler;
use BristolSU\ControlDB\Export\Handler\SaveCsvHandler;
use Closure;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Str;
use InvalidArgumentException;

class ExportManager
{

    /**
     * The container instance.
     *
     * @var Container
     */
    protected $container;

    /**
     * The registered custom driver creators.
     *
     * @var array
     */
    protected $customCreators = [];
    
    protected $formatters = [];

    /**
     * Create a new Export manager instance.
     *
     * @param  Container  $container
     * @return void
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Get a export driver instance.
     *
     * @param  string|null  $driver
     * @return mixed
     */
    public function driver($driver = null)
    {
        return $this->resolve($driver ?? $this->getDefaultDriver());
    }

    /**
     * Resolve the given export instance by name.
     *
     * @param  string  $name
     * @return Handler
     *
     * @throws \InvalidArgumentException
     */
    protected function resolve($name)
    {
        $config = $this->configurationFor($name);

        if (is_null($config)) {
            throw new InvalidArgumentException("Exporter [{$name}] is not defined.");
        }
        if (isset($this->customCreators[$config['driver']])) {
            return $this->callCustomCreator($config);
        }

        $driverMethod = 'create'.Str::studly($config['driver']).'Driver';

        if (method_exists($this, $driverMethod)) {
            return $this->{$driverMethod}($config);
        }

        throw new InvalidArgumentException("Driver [{$config['driver']}] is not supported.");
    }

    /**
     * Call a custom driver creator.
     *
     * @param  array  $config
     * @return mixed
     */
    protected function callCustomCreator(array $config)
    {
        return $this->customCreators[$config['driver']]($this->container, $config);
    }
    
    /**
     * Get the export connection configuration.
     *
     * @param  string  $name
     * @return array
     */
    protected function configurationFor($name)
    {
        $config = $this->container['config']["control.export.{$name}"];
        if(is_null($config)) {
            return null;
        }
        if(!isset($config['formatters'])) {
            $config['formatters'] = [];
        }
        foreach($this->formatters() as $formatter => $formatterConfig) {
            $config['formatters'][$formatter] = $formatterConfig;
        }
        
        return $config;
    }

    /**
     * Get the default export driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->container['config']['control.export.default'];
    }

    /**
     * Register a custom driver creator Closure.
     *
     * @param  string  $driver
     * @param  \Closure  $callback
     * @return $this
     */
    public function extend($driver, Closure $callback)
    {
        $this->customCreators[$driver] = $callback->bindTo($this, $this);

        return $this;
    }

    public function withFormatter(string $formatter, array $config = [])
    {
        $this->formatters[$formatter] = $config;
        
        return $this;
    }
    
    /**
     * Dynamically call the default driver instance.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->driver()->$method(...$parameters);
    }

    public function createDumpDriver(array $config)
    {
        return new DumpHandler($config);
    }

    public function createSaveCsvDriver(array $config)
    {
        return new SaveCsvHandler($config);
    }

    protected function formatters()
    {
        return $this->formatters;
    }

}