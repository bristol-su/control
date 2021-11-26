<?php

namespace BristolSU\ControlDB\Export;

use BristolSU\ControlDB\Contracts\Repositories\Group;
use BristolSU\ControlDB\Contracts\Repositories\Position;
use BristolSU\ControlDB\Contracts\Repositories\Role;
use BristolSU\ControlDB\Contracts\Repositories\User;
use BristolSU\ControlDB\Models\Lazy\LazyGroup;
use BristolSU\ControlDB\Models\Lazy\LazyPosition;
use BristolSU\ControlDB\Models\Lazy\LazyRole;
use BristolSU\ControlDB\Models\Lazy\LazyUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Exception\InvalidArgumentException;

class RunExport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $exporter;
    private string $type;
    private int $page;

    public function __construct(string $exporter, string $type, int $page = 1)
    {
        $this->exporter = $exporter;
        $this->type = $type;
        $this->page = $page;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info(sprintf('About to run %s with page %u', $this->type, $this->page));
        Exporter::driver($this->exporter)->export($this->getData());
        Log::info(sprintf('Ran %s with page %u', $this->type, $this->page));
    }

    private function getData()
    {
        switch($this->type) {
            case 'user':
                return app(User::class)->paginate($this->page, 200);
                break;
            case 'group':
                return app(Group::class)->paginate($this->page, 200);
                break;
            case 'role':
                return app(Role::class)->paginate($this->page, 200);
                break;
            case 'position':
                return app(Position::class)->paginate($this->page, 200);
                break;
            default:
                throw new InvalidArgumentException(sprintf('The type option %s is not allowed.', $this->type));
                break;
        }
    }
}
