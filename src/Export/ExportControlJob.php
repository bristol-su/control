<?php

namespace BristolSU\ControlDB\Export;

use BristolSU\ControlDB\Contracts\Repositories\Group;
use BristolSU\ControlDB\Contracts\Repositories\Position;
use BristolSU\ControlDB\Contracts\Repositories\Role;
use BristolSU\ControlDB\Contracts\Repositories\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Exception\InvalidArgumentException;

/**
 * @method static void dispatch(int $page, string $type, string $driver) Set the export going for a specific type of resource
 */
class ExportControlJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    private const PER_PAGE = 500;

    private int $page;

    private string $type;
    private string $driver;

    public function __construct(int $page, string $type, string $driver)
    {
        $this->page = $page;
        $this->type = $type;
        $this->driver = $driver;
    }

    public function handle()
    {
        $exportData = $this->exportData();
        if($exportData->count() > 0) {
            Exporter::driver($this->driver)->export($exportData);
            ExportControlJob::dispatch($this->page + 1, $this->type, $this->driver);
        }
    }

    private function exportData(): Collection
    {
        switch($this->type) {
            case 'user':
                return app(User::class)->paginate($this->page, static::PER_PAGE);
                break;
            case 'group':
                return app(Group::class)->paginate($this->page, static::PER_PAGE);
                break;
            case 'role':
                return app(Role::class)->paginate($this->page, static::PER_PAGE);
                break;
            case 'position':
                return app(Position::class)->paginate($this->page, static::PER_PAGE);
                break;
            default:
                throw new InvalidArgumentException(sprintf('The type option %s is not allowed.', $this->type));
                break;
        }
    }

}
