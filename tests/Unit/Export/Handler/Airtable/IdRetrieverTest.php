<?php

namespace BristolSU\Tests\ControlDB\Unit\Export\Handler\Airtable;

use BristolSU\ControlDB\Export\Handler\Airtable\IdRetriever;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class IdRetrieverTest extends TestCase
{

    /** @test */
    public function it_can_retrieve_ids_from_the_cache(){
        $ids = ['a', 'b', 'c'];
        $cache = $this->prophesize(Repository::class);
        $cache->get(IdRetriever::class . ':myBaseId:myTableName')->shouldBeCalled()->willReturn($ids);
        
        $idRetriever = new IdRetriever($cache->reveal(), 'myBaseId', 'myTableName');
        $retrievedIds = $idRetriever->ids();
        
        $this->assertInstanceOf(Collection::class, $retrievedIds);
        $this->assertEquals(3, $retrievedIds->count());
        $this->assertEquals('a', $retrievedIds->offsetGet(0));
        $this->assertEquals('b', $retrievedIds->offsetGet(1));
        $this->assertEquals('c', $retrievedIds->offsetGet(2));
        
    }
    
    /** @test */
    public function an_id_can_be_added_to_the_cache(){
        $ids = ['a', 'b', 'c'];
        $cache = $this->prophesize(Repository::class);
        $cache->get(IdRetriever::class . ':myBaseId:myTableName')->shouldBeCalled()->willReturn($ids);
        $cache->forever(IdRetriever::class . ':myBaseId:myTableName', ['a', 'b', 'c', 'd'])
            ->shouldBeCalled();

        $idRetriever = new IdRetriever($cache->reveal(), 'myBaseId', 'myTableName');
        $idRetriever->pushId('d');

    }
    
    /** @test */
    public function ids_can_be_added_to_the_cache(){
        $ids = ['a', 'b', 'c'];
        $cache = $this->prophesize(Repository::class);
        $cache->get(IdRetriever::class . ':myBaseId:myTableName')->shouldBeCalled()->willReturn($ids);
        $cache->forever(IdRetriever::class . ':myBaseId:myTableName', ['a', 'b', 'c', 'd', 'e'])
            ->shouldBeCalled();

        $idRetriever = new IdRetriever($cache->reveal(), 'myBaseId', 'myTableName');
        $idRetriever->pushIds(['d', 'e']);
    }
    
    /** @test */
    public function the_ids_can_be_overwritten(){
        $ids = ['a', 'b', 'c'];
        $cache = $this->prophesize(Repository::class);
        $cache->forever(IdRetriever::class . ':myBaseId:myTableName', ['d', 'e', 'f'])
            ->shouldBeCalled();

        $idRetriever = new IdRetriever($cache->reveal(), 'myBaseId', 'myTableName');
        $idRetriever->saveIds(['d', 'e', 'f']);
    }
    
}