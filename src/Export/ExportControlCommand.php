<?php

namespace BristolSU\ControlDB\Export;

use BristolSU\ControlDB\Contracts\Repositories\Group;
use BristolSU\ControlDB\Contracts\Repositories\Position;
use BristolSU\ControlDB\Contracts\Repositories\Role;
use BristolSU\ControlDB\Contracts\Repositories\User;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Exception\InvalidArgumentException;

/**
 * Seed the database
 */
class ExportControlCommand extends Command
{
    /**
     * Signature for the command
     *
     * @var string
     */
    protected $signature = 'control:export
                            {type : The type of resource to export}
                            {--exporter= : The name of the exporter to use}';

    /**
     * Name for the commmand
     *
     * @var string
     */
    protected $name = 'Export Control';

    /**
     * Description of the command
     *
     * @var string
     */
    protected $description = 'Export control to an external service';

    /**
     * Handle the command execution
     *
     * Seed the database with fake data.
     */
    public function handle()
    {
        $type = $this->argument('type');
        if(!in_array(
            $type,
            ['user', 'group', 'role', 'position']
        )) {
            throw new InvalidArgumentException(sprintf('The type option %s is not allowed.', $type));
        }
        ExportControlJob::dispatch(1, $type, $this->option('exporter'));

        $this->info('Export running in the background.');
    }

}
