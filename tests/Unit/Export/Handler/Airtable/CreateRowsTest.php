<?php

namespace BristolSU\Tests\ControlDB\Unit\Export\Handler\Airtable;

use BristolSU\ControlDB\Export\Handler\Airtable\CreateRows;
use BristolSU\ControlDB\Export\Handler\Airtable\IdRetriever;
use BristolSU\Tests\ControlDB\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;

class CreateRowsTest extends TestCase
{


    /** @test */
    public function the_correct_api_call_is_executed(){
        $data = ['records' => [
            ['fields' => ['test' => '123']], ['fields' => ['test' => '456']]
        ], 'typecast' => true];
        $job = new CreateRows($data, 'myApiKey1', 'myBaseId1', 'myTableName1');

        $response = new Response(200, [], json_encode([
            'records' => [
                [
                    'id' => 'rec1',
                    'fields' => ['test' => '123']    
                ],
                [
                    'id' => 'rec2',
                    'fields' => ['test' => '456']
                ],
            ]
        ]));
        
        $client = $this->prophesize(Client::class);
        $client->post('https://api.airtable.com/v0/myBaseId1/myTableName1', [
            'json' => $data,
            'headers' => [
                'Authorization' => 'Bearer myApiKey1'
            ]
        ])->shouldBeCalled()->willReturn($response);

        $job->handle($client->reveal());
    }
    
    /** @test */
    public function ids_are_saved_in_the_cache(){
        $data = ['records' => [
            ['fields' => ['test' => '123']], ['fields' => ['test' => '456']]
        ], 'typecast' => true];
        $job = new CreateRows($data, 'myApiKey1', 'myBaseId1', 'myTableName1');

        $response = new Response(200, [], json_encode([
            'records' => [
                [
                    'id' => 'rec1',
                    'fields' => ['test' => '123']
                ],
                [
                    'id' => 'rec2',
                    'fields' => ['test' => '456']
                ],
            ]
        ]));
        
        $client = $this->prophesize(Client::class);
        $client->post('https://api.airtable.com/v0/myBaseId1/myTableName1', [
            'json' => $data,
            'headers' => [
                'Authorization' => 'Bearer myApiKey1'
            ]
        ])->shouldBeCalled()->willReturn($response);

        $job->handle($client->reveal());
        
        $ids = app(IdRetriever::class, [
            'baseId' => 'myBaseId1',
            'tableName' => 'myTableName1'
        ])->ids()->toArray();
        $this->assertIsArray($ids);
        $this->assertCount(2, $ids);
        $this->assertEquals(['rec1', 'rec2'], $ids);
    }
    
}