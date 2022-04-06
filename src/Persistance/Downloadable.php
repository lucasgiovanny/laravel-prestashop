<?php

namespace Lucasgiovanny\LaravelPrestashop\Persistance;

use Lucasgiovanny\LaravelPrestashop\Prestashop;
use GuzzleHttp\Client;

trait Downloadable
{
     /**
     * @return Prestashop
     */
    abstract public function connection(): Prestashop;

    /**
     * @return string
     */
    abstract public function getDownloadUrl(): string;

    /**
     * @return mixed Binary representation of file
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function download()
    {
        $client = new Client();

        $headers = [
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'Authorization' => 'Basic ' . $this->connection()->getAccessToken(),
        ];
        $res = $client->get($this->getDownloadUrl(), [
            'headers' => $headers,
        ]);
        return $res->getBody();
    }
}
