<?php

namespace LucasGiovanny\LaravelPrestashop\Tests\Support;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use LucasGiovanny\LaravelPrestashop\Prestashop;

trait MocksPrestashopConnection
{
    protected $mockHandler;

    protected function createMockConnection(): Prestashop
    {
        $httpClient = new Client([
            'handler' => $this->mockHandler,
        ]);
        $presta = new Prestashop($httpClient);
        $presta->shop('https://prestashop.pdik.nl', '/api', '1224356432');

        return $presta;
    }

    protected function createMockHandlerUsingFixture(string $fixture)
    {
        $this->mockHandler = new MockHandler();
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__."/../fixtures/$fixture")));
    }
}
