<?php

declare(strict_types=1);

namespace Albion\OnlineDataProject\Infrastructure\DataProject;

use Albion\OnlineDataProject\Domain\Realm;
use Albion\OnlineDataProject\Domain\RealmHosts;
use GuzzleHttp\Client;

abstract class AbstractClient
{
    public function __construct(protected Client $httpClient)
    {
    }

    protected function endpointUrl(Realm $realm, string $endpoint): string
    {
        $api_host = RealmHosts::fromRealm($realm)->value;
        return "{$api_host}/{$endpoint}";
    }
}
