<?php

declare(strict_types=1);

namespace Albion\OnlineDataProject\Domain;

enum Realm: string
{
    case WEST = 'west';
    case EAST = 'east';
    case AMERICAS = 'americas';
    case ASIA = 'asia';
    case EUROPE = 'europe';
}
