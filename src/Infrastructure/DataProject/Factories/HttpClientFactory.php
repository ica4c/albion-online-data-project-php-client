<?php

namespace Albion\OnlineDataProject\Infrastructure\DataProject\Factories;

use Albion\OnlineDataProject\Domain\Realm;
use Albion\OnlineDataProject\Domain\RealmHosts;
use GuzzleHttp\Client;

class HttpClientFactory
{
    public static function makeByRealm(Realm $realm): Client
    {
        return new Client([
            'base_uri' => RealmHosts::fromRealm($realm)->toString(),
            'timeout' => 30
        ]);
    }
}