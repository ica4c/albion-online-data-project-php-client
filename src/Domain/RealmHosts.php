<?php

declare(strict_types=1);

namespace Albion\OnlineDataProject\Domain;

enum RealmHosts: string
{
    case EAST = 'https://east.albion-online-data.com';
    case WEST = 'https://west.albion-online-data.com';
    case EUROPE = 'https://europe.albion-online-data.com';

    public static function fromRealm(Realm $realm): self
    {
        return match ($realm) {
            Realm::EAST, Realm::ASIA => self::EAST,
            Realm::WEST, Realm::AMERICAS => self::WEST,
            Realm::EUROPE => self::EUROPE,
        };
    }
}
