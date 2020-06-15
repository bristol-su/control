<?php


namespace BristolSU\ControlDB\Export\Handler\Airtable;


use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Export\FormattedItem;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class IdRetriever
{

    /**
     * @var Repository
     */
    private Repository $cache;
    private $baseId;
    private $tableName;

    public function __construct(Repository $cache, $baseId, $tableName)
    {
        $this->cache = $cache;
        $this->baseId = $baseId;
        $this->tableName = $tableName;
    }

    public function ids(): Collection
    {
        return collect(
            $this->cache->get($this->key())
        );
    }

    public function saveIds($ids)
    {
        if($ids instanceof Collection) {
            $ids = $ids->toArray();
        }
        $this->cache->forever($this->key(), $ids);
    }
    
    public function pushIds(array $ids): void
    {
        $currentIds = $this->ids();
        $this->saveIds($currentIds->concat($ids));
    }

    public function pushId(string $id): void
    {
        $currentIds = $this->ids();
        $currentIds->push($id);
        $this->saveIds($currentIds);
    }

    private function key()
    {
        return static::class . ':' . $this->baseId . ':' . $this->tableName;
    }

}