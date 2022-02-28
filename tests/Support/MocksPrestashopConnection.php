<?php

namespace Lucasgiovanny\LaravelPrestashop\Tests\Support;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Illuminate\Http\Response;
use Lucasgiovanny\LaravelPrestashop\Prestashop;
trait MocksPrestashopConnection
{
    protected function createMockConnection(callable $mockHandler): Prestashop
    {
        $handlerStack = HandlerStack::create($mockHandler);
        $client = new Client(['handler' => $handlerStack]);
        $connection = new Prestashop($client);
        return $connection;
    }

    /**
     * @param  array|string|null  $response
     *
     * @return MockHandler
     */
    protected function createMockHandler($response = null): MockHandler
    {
        return new MockHandler(
            $this->normalizeResponse($response)
        );
    }

    protected function createMockHandlerUsingFixture(string $fixture): MockHandler
    {
        return $this->createMockHandler(
            file_get_contents(__DIR__."/../fixtures/$fixture")
        );
    }

    protected function normalizeResponse($response = null): array
    {
        if (is_array($response)) {
            return $response;
        }

        if (is_string($response)) {
            return [new Response($response,200, [],)];
        }

        if ($response instanceof Response) {
            return [$response];
        }

        return [];
    }
}
