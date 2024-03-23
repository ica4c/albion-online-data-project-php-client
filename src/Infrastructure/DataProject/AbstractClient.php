<?php

namespace Albion\OnlineDataProject\Infrastructure\DataProject;

use GuzzleHttp\Client;

abstract class AbstractClient
{
    protected Client $httpClient;

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