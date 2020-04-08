<?php

namespace BristolSU\ControlDB\Export;

use BristolSU\ControlDB\Contracts\Repositories\Group;
use BristolSU\ControlDB\Contracts\Repositories\Position;
use BristolSU\ControlDB\Contracts\Repositories\Role;
use BristolSU\ControlDB\Contracts\Repositories\User;
use BristolSU\ControlDB\Export\Formatter\Role\SortByGroupName;
use BristolSU\ControlDB\Export\Formatter\Shared\SortByColumn;
use Illuminate\Console\Command;
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
        Exporter::driver($this->option('exporter'))->export($this->exportData());
        $this->info('Export complete');
    }

    private function exportData()
    {
        switch($this->argument('type')) {
            case 'user': 
                return app(User::class)->all();
                break;
            case 'group':
                return app(Group::class)->all();
                break;
            case 'role':
                return app(Role::class)->all();
                break;
            case 'position':
                return app(Position::class)->all();
                break;
            default:
                throw new InvalidArgumentException(sprintf('The type option %s is not allowed.', $this->argument('type')));
                break;
        }
    }
}