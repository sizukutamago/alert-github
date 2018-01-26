<?php

namespace App;


use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class SlackAPI
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function sendMessage(string $url, string $message)
    {
        $this->client->post($url, [
            RequestOptions::JSON => [
                'text' => $message
            ]
        ]);
    }
}
