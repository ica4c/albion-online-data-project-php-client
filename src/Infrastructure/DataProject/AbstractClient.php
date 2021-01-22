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
     * AbstractClient constructor.
     *
     * @param \GuzzleHttp\Client $httpBackend
     */
    public function __construct(Client $httpBackend)
    {
        $this->httpClient = $httpBackend;
    }
}