<?php

namespace Albion\OnlineDataProject\Domain;

use Solid\Foundation\Enum;

class Markets extends Enum
{
    const BLACK_MARKET = 'Black Market';
    const CAERLEON = 'Caerleon';
    const BRIDGEWATCH = 'Bridgewatch';
    const BRIDGEWATCH_PORTAL = 'Bridgewatch Portal';
    const FORT_STERLING = 'FortSterling';
    const FORT_STERLING_PORTAL = 'Fort Sterling Portal';
    const THETFORD = 'Thetford';
    const THETFORD_PORTAL = 'Thetford Portal';
    const MARTLOCK = 'Martlock';
    const MARTLOCK_PORTAL = 'Martlock Portal';
    const LYMHURST = 'Lymhurst';
    const LYMHURST_PORTAL = 'Lymhurst Portal';
    const MORGANAS_REST = 'Morganas Rest';
    const ARTHURS_REST = 'Arthurs Rest';
    const MERLINS_REST = 'Merlins Rest';
}