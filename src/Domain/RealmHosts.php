<?php

namespace Albion\OnlineDataProject\Domain;

use InvalidArgumentException;
use Solid\Foundation\Enum;

class RealmHosts extends Enum
{
    public const EAST = 'https://east.albion-online-data.com';
    public const WEST = 'https://west.albion-online-data.com';

    /**
     * @param Realm $realm
     *
     * @return self
     * 
     * @throws \Solid\Foundation\Exceptions\InvalidEnumValueException
     */
    public static function fromRealm(Realm $realm): self
    {
        switch ($realm->value) {
            case Realm::EAST:
                return self::of(self::EAST);

            case Realm::WEST:
                return self::of(self::WEST);

            default:
                throw new InvalidArgumentException('Unsupported realm value');
        }
    }
}