<?php

namespace LucasGiovanny\LaravelPrestashop\Persistance;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use LucasGiovanny\LaravelPrestashop\Prestashop;
use Psr\Http\Message\StreamInterface;

trait Downloadable
{
    abstract public function connection(): Prestashop;

    abstract public function getDownloadUrl(): string;

    /**
     * @return StreamInterface Binary representation of file
     *
     * @throws GuzzleException
     */
    public function download(): StreamInterface
    {
        $client = new Client();

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic '.$this->connection()->getAccessToken(),
        ];
        $res = $client->get($this->getDownloadUrl(), [
            'headers' => $headers,
        ]);

        return $res->getBody();
    }
}
