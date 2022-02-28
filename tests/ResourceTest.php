<?php

namespace Lucasgiovanny\LaravelPrestashop\Tests;
use Generator;
use Lucasgiovanny\LaravelPrestashop\Query\Resultset;
use Lucasgiovanny\LaravelPrestashop\Resources\Orders;
use PHPUnit\Framework\TestCase;
use Lucasgiovanny\LaravelPrestashop\Tests\Support\MocksPrestashopConnection;
class ResourceTest
{
 use MocksPrestashopConnection;

    public function testCanFindModel()
    {
        $handler = $this->createMockHandlerUsingFixture('order.json');
        $connection = $this->createMockConnection($handler);

        $response = (new Orders($connection))->find('6');
        $this->assertInstanceOf(Orders::class, $response);
        $this->assertEquals('6', $response->primaryKeyContent());
    }

    public function testCanGetFirstModel()
    {
        $handler = $this->createMockHandlerUsingFixture('order.json');
        $connection = $this->createMockConnection($handler);

        $response = (new Orders($connection))->first();

        $this->assertInstanceOf(Orders::class, $response);
        $this->assertEquals('6', $response->primaryKeyContent());
    }

    public function testCanGetModels()
    {
        $handler = $this->createMockHandlerUsingFixture('orders.json');
        $connection = $this->createMockConnection($handler);

        $response = (new Orders($connection))->get();

        $this->assertIsArray($response);
        $this->assertInstanceOf(Orders::class, $response[0]);
        $this->assertCount(2, $response);
    }

    public function testCanGetModelsAsGenerator()
    {
        $handler = $this->createMockHandlerUsingFixture('orders.json');
        $connection = $this->createMockConnection($handler);
        $response = (new Orders($connection))->getAsGenerator();
        $this->assertInstanceOf(Generator::class, $response);
        $this->assertCount(2, $response);
    }

    public function testCanFilterModels()
    {
        $handler = $this->createMockHandlerUsingFixture('orders.json');
        $connection = $this->createMockConnection($handler);

        $response = (new Orders($connection))->filter('id','=','6');

        $this->assertIsArray($response);
        $this->assertInstanceOf(Orders::class, $response[0]);
        $this->assertCount(1, $response);
    }

    public function testCanWhereModelsAsGenerator()
    {
        $handler = $this->createMockHandlerUsingFixture('orders.json');
        $connection = $this->createMockConnection($handler);

        $response = (new Orders($connection))->where('id','=','8');
        $this->assertInstanceOf(Generator::class, $response);
        $this->assertCount(1, $response);
    }

    public function testCanGetCollectionFromResult()
    {
        $handler = $this->createMockHandlerUsingFixture('orders.json');
        $connection = $this->createMockConnection($handler);
        $item = new Orders($connection);

        $result = $connection->get($item->url(), []);
        $collection = $item->collectionFromResult($result);

        $this->assertIsArray($collection);
        $this->assertInstanceOf(Orders::class, $collection[0]);
        $this->assertCount(2, $collection);
    }

    public function testCanGetCollectionFromResultAsGenerator()
    {
        $handler = $this->createMockHandlerUsingFixture('orders.json');
        $connection = $this->createMockConnection($handler);
        $item = new Orders($connection);
        $result = $connection->get($item->url(), []);
        $collection = $item->collectionFromResultAsGenerator($result);

        $this->assertInstanceOf(Generator::class, $collection);
        $this->assertCount(2, $collection);
    }

    public function testCanGetResultSet()
    {
        $handler = $this->createMockHandler();
        $connection = $this->createMockConnection($handler);
        $resultset = (new Orders($connection))->getResultSet();
        $this->assertInstanceOf(Resultset::class, $resultset);
    }
}
