<?php

declare(strict_types=1);

namespace Albion\OnlineDataProject\Domain;

enum Markets: string
{
    case UNKNOWN = "0";
    case BLACK_MARKET = 'Black Market';
    case CAERLEON = 'Caerleon';
    case BRIDGEWATCH = 'Bridgewatch';
    case BRIDGEWATCH_PORTAL = 'Bridgewatch Portal';
    case FORT_STERLING = 'Fort Sterling';
    case FORT_STERLING_PORTAL = 'Fort Sterling Portal';
    case THETFORD = 'Thetford';
    case THETFORD_PORTAL = 'Thetford Portal';
    case MARTLOCK = 'Martlock';
    case MARTLOCK_PORTAL = 'Martlock Portal';
    case LYMHURST = 'Lymhurst';
    case LYMHURST_PORTAL = 'Lymhurst Portal';
    case MORGANAS_REST = 'Morganas Rest';
    case ARTHURS_REST = 'Arthurs Rest';
    case MERLYNS_REST = 'Merlyns Rest';
    case BRECILIEN = 'Brecilien';
    case SMUGGLERS_NETWORK = 'Smugglers Network';
}
