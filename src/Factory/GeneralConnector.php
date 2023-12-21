<?php

namespace App\Factory;

use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class GeneralConnector
{
    /**
     * A response data is
     *
     * @var string
     */
    protected string $data;

    /**
     * A Guzzle client is
     *
     * @var Client
     */
    protected Client $client;
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'protocols' => ['https']
        ]);
    }
}