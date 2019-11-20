<?php

namespace BristolSU\ControlDB\Commands;

use Illuminate\Console\Command;

class SeedDatabase extends Command
{
    protected $signature = 'control:seed';

    protected $name = 'Seed Control';

    protected $description = 'Seed the control database with fake data';

    public function handle()
    {
        $this->call('db:seed', ['--class' => 'SeedControlDatabase']);
    }
}