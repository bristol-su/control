<?php

namespace BristolSU\Tests\ControlDB\Unit\Export\Handler\Airtable;

use BristolSU\ControlDB\Export\Handler\Airtable\DeleteRows;
use BristolSU\Tests\ControlDB\TestCase;
use GuzzleHttp\Client;

class DeleteRowsTest extends TestCase
{


    /** @test */
    public function the_correct_api_call_is_executed(){
        $data = ['records' => [
            'rec1', 'rec2'
        ]];
        $job = new DeleteRows($data, 'myApiKey1', 'myBaseId1', 'myTableName1');

        $client = $this->prophesize(Client::class);
        $client->delete('https://api.airtable.com/v0/myBaseId1/myTableName1', [
            'query' => $data,
            'headers' => [
                'Authorization' => 'Bearer myApiKey1'
            ]
        ])->shouldBeCalled();

        $job->handle($client->reveal());
    }
    
}