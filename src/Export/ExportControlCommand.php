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
        $time=-hrtime(true);
        foreach($this->exportData() as $collection) {
            Exporter::driver($this->option('exporter'))->export($collection);
        }
        $this->info('Export complete');
        $time+=hrtime(true);
        $this->info(sprintf('Export took %.2f s to run', $time / 1e+9));
    }

    /**
     * @return \Generator|Collection[]
     */
    private function exportData()
    {
        $page = 1;
        $complete = false;

        switch($this->argument('type')) {
            case 'user':
                while ($complete === false) {
                    $result = app(User::class)->paginate($page, 100);
                    if($result->count() > 0) {
                        yield $result;
                    } else {
                        $complete = true;
                    }
                }
                break;
            case 'group':
                while ($complete === false) {
                    $result = app(Group::class)->paginate($page, 20);
                    if($result->count() > 0) {
                        yield $result;
                    } else {
                        $complete = true;
                    }
                }
                break;
            case 'role':
                while ($complete === false) {
                    $result = app(Role::class)->paginate($page, 20);
                    if($result->count() > 0) {
                        yield $result;
                    } else {
                        $complete = true;
                    }
                }
                break;
            case 'position':
                while ($complete === false) {
                    $result = app(Position::class)->paginate($page, 20);
                    if($result->count() > 0) {
                        yield $result;
                    } else {
                        $complete = true;
                    }
                }
                break;
            default:
                throw new InvalidArgumentException(sprintf('The type option %s is not allowed.', $this->argument('type')));
                break;
        }
    }

}
