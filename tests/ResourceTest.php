<?php

namespace Lucasgiovanny\LaravelPrestashop\Tests;

use Generator;

use GuzzleHttp\Handler\MockHandler;

use Lucasgiovanny\LaravelPrestashop\Prestashop;
use Lucasgiovanny\LaravelPrestashop\Query\Resultset;
use Lucasgiovanny\LaravelPrestashop\Resources\Orders;

use Lucasgiovanny\LaravelPrestashop\Tests\Support\MocksPrestashopConnection;

class ResourceTest extends  \Orchestra\Testbench\TestCase

{
    use MocksPrestashopConnection;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @throws \Lucasgiovanny\LaravelPrestashop\Exceptions\CouldNotFindFilter
     */
    public function testCanFindModel()
    {
        $this->createMockHandlerUsingFixture('order.json');
        $connection = $this->createMockConnection();
        $response = (new Orders($connection))->find('6');
        $this->assertInstanceOf(Orders::class, get_class($response));
        $this->assertEquals('6', $response->primaryKeyContent());
    }

    /**
     * @throws \Lucasgiovanny\LaravelPrestashop\Exceptions\CouldNotConnectException
     */
    public function testCanGetFirstModel()
    {
        $this->createMockHandlerUsingFixture('order.json');
        $connection = $this->createMockConnection();

        $response = (new Orders($connection))->first();

        $this->assertInstanceOf(Orders::class, $response);
        $this->assertEquals('6', $response->primaryKeyContent());
    }

    /**
     * @throws \Lucasgiovanny\LaravelPrestashop\Exceptions\ConfigException
     * @throws \Lucasgiovanny\LaravelPrestashop\Exceptions\CouldNotConnectException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testCanGetModels()
    {
        $this->createMockHandlerUsingFixture('orders.json');
        $connection = $this->createMockConnection();

        $response = (new Orders($connection))->get();

        $this->assertIsArray($response);
        $this->assertInstanceOf(Orders::class, $response[0]);
        $this->assertCount(2, $response);
    }


    /**
     * @throws \Lucasgiovanny\LaravelPrestashop\Exceptions\ConfigException
     * @throws \Lucasgiovanny\LaravelPrestashop\Exceptions\CouldNotConnectException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function testCanFilterModels()
    {
        $this->createMockHandlerUsingFixture('orders.json');
        $connection = $this->createMockConnection();

        $response = (new Orders($connection))->filter('id', '=', '6')->get();

        $this->assertIsArray($response);
        $this->assertInstanceOf(Orders::class, $response[0]);
        $this->assertCount(1, $response);
    }

    /**
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */


}
