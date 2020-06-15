<?php

namespace BristolSU\ControlDB\Export\Handler\Airtable;

use BristolSU\ControlDB\Export\FormattedItem;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Support\Collection;

class CreateRows implements ShouldQueue
{
    use Dispatchable, Queueable;

    private array $data;
    private string $apiKey;
    private string $baseId;
    private string $tableName;
    /**
     * @var Collection
     */
    private Collection $creatingItems;

    /**
     * CreateRows constructor.
     * @param array $data
     * @param string $apiKey
     * @param string $baseId
     * @param string $tableName
     * @param Collection|FormattedItem[] $creatingItems
     */
    public function __construct(array $data, string $apiKey, string $baseId, string $tableName)
    {
        $this->data = $data;
        $this->apiKey = $apiKey;
        $this->baseId = $baseId;
        $this->tableName = $tableName;
    }

    public function handle(Client $client)
    {
        $response = $client->post(
            sprintf('https://api.airtable.com/v0/%s/%s', $this->baseId, $this->tableName),
            [
                'json' => $this->data,
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey
                ]
            ]
        );
        
        /** @var IdRetriever $idRetriver */
        $idRetriver = app(IdRetriever::class, [
            'baseId' => $this->baseId,
            'tableName' => $this->tableName
        ]);
        
        $records = json_decode($response->getBody()->getContents(), true);
        foreach($records['records'] as $record) {
            $idRetriver->pushId($record['id']);
        }
    }

}