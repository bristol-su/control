<?php

namespace BristolSU\ControlDB\Commands;

use Illuminate\Console\Command;

/**
 * Seed the database
 */
class SeedDatabase extends Command
{
    /**
     * Signature for the command
     * 
     * @var string 
     */
    protected $signature = 'control:seed';

    /**
     * Name for the commmand
     * 
     * @var string 
     */
    protected $name = 'Seed Control';

    /**
     * Description of the command
     * 
     * @var string 
     */
    protected $description = 'Seed the control database with fake data';

    /**
     * Handle the command execution
     * 
     * Seed the database with fake data.
     */
    public function handle()
    {
        $this->call('db:seed', ['--class' => 'SeedControlDatabase']);
    }
}