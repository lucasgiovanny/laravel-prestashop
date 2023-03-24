<?php

namespace LucasGiovanny\LaravelPrestashop\Tests;

use LucasGiovanny\LaravelPrestashop\Resources\Orders;
use LucasGiovanny\LaravelPrestashop\Tests\Support\MocksPrestashopConnection;

class ResourceTest extends \Orchestra\Testbench\TestCase
{
    use MocksPrestashopConnection;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @throws \LucasGiovanny\LaravelPrestashop\Exceptions\CouldNotFindFilter
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
     * @throws \LucasGiovanny\LaravelPrestashop\Exceptions\CouldNotConnectException
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
     * @throws \LucasGiovanny\LaravelPrestashop\Exceptions\ConfigException
     * @throws \LucasGiovanny\LaravelPrestashop\Exceptions\CouldNotConnectException
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
     * @throws \LucasGiovanny\LaravelPrestashop\Exceptions\ConfigException
     * @throws \LucasGiovanny\LaravelPrestashop\Exceptions\CouldNotConnectException
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
