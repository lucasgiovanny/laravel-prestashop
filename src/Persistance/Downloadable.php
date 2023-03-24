<?php

namespace LucasGiovanny\LaravelPrestashop\Persistance;

use GuzzleHttp\Client;
use LucasGiovanny\LaravelPrestashop\Prestashop;

trait Downloadable
{
    abstract public function connection(): Prestashop;

    abstract public function getDownloadUrl(): string;

    /**
     * @return mixed Binary representation of file
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function download()
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
