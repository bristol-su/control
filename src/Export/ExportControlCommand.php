<?php

namespace BristolSU\ControlDB\Export;

use BristolSU\ControlDB\Contracts\Repositories\Group;
use BristolSU\ControlDB\Contracts\Repositories\Position;
use BristolSU\ControlDB\Contracts\Repositories\Role;
use BristolSU\ControlDB\Contracts\Repositories\User;
use Illuminate\Console\Command;
use Illuminate\Support\LazyCollection;
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
        $time=-hrtime(true);
        foreach($this->pages() as $page) {
            RunExport::dispatch($this->option('exporter'), $this->exportData($page));
        }
        $this->info('Export complete');
        $time+=hrtime(true);
        $this->info(sprintf('Export took %.2f s to run', $time / 1e+9));
    }

    private function pages(): array
    {
        switch($this->argument('type')) {
            case 'user':
                $count = app(User::class)->count();
                break;
            case 'group':
                $count = app(Group::class)->count();
                break;
            case 'role':
                $count = app(Role::class)->count();
                break;
            case 'position':
                $count = app(Position::class)->count();
                break;
            default:
                $count = 0;
        }

        return range(0, $count);
    }

    private function exportData(int $page)
    {
        switch($this->argument('type')) {
            case 'user':
                return app(User::class)->paginate($page, 200);
                break;
            case 'group':
                return app(Group::class)->paginate($page, 200);
                break;
            case 'role':
                return app(Role::class)->paginate($page, 200);
                break;
            case 'position':
                return app(Position::class)->paginate($page, 200);
                break;
            default:
                throw new InvalidArgumentException(sprintf('The type option %s is not allowed.', $this->argument('type')));
                break;
        }
    }
}
