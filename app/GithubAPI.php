<?php

namespace App;


use GuzzleHttp\Client;

class GithubAPI
{
    /**
     * @var Client
     */
    private $client;

    /**
     * githubのurl
     *
     * @var string
     */
    private $base_uri;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->base_uri = 'https://api.github.com';
    }

    /**
     * ユーザ名からそのユーザのコミットを全て取得します
     *
     * @param string $name
     * @return array
     */
    public function getCommitsByName(string $name) :array
    {
        $path = "/users/{$name}/events";

        $response = $this->client->get($this->base_uri . $path);
        $body = $response->getBody()->getContents();
        return json_decode($body, true);
    }
}
