<?php

namespace Albion\OnlineDataProject\Infrastructure\DataProject;

use GuzzleHttp\Client;

abstract class AbstractClient
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * AbstractGamestatsClient constructor.
     */
    public function __construct()
    {
        $this->httpClient = new Client([
            'base_uri' => 'https://www.albion-online-data.com/api/v2/'
        ]);
    }
}