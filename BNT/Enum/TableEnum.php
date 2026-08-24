<?php

declare(strict_types=1);

namespace BNT\Enum;

enum TableEnum
{
    case Ships;
    case Traderoutes;
    case Links;
    case Planets;
    case Sectors;
    case Zones;
    case SectorDefences;
    case Bounty;
    case Logs;
    case News;

    public function toDb(): string
    {
        global $dbtables;
        $prefix = (defined('BNT_DATABASE_PREFIX') ? BNT_DATABASE_PREFIX : (getenv('BNT_DATABASE_PREFIX') ?: 'bnt_'));

        return match ($this) {
            TableEnum::News => $dbtables['news'] ?? ($prefix . 'news'),
            TableEnum::Ships => $dbtables['ships'] ?? ($prefix . 'ships'),
            TableEnum::Traderoutes => $dbtables['traderoutes'] ?? ($prefix . 'traderoutes'),
            TableEnum::Links => $dbtables['links'] ?? ($prefix . 'links'),
            TableEnum::Planets => $dbtables['planets'] ?? ($prefix . 'planets'),
            TableEnum::Sectors => $dbtables['universe'] ?? ($prefix . 'universe'),
            TableEnum::Zones => $dbtables['zones'] ?? ($prefix . 'zones'),
            TableEnum::SectorDefences => $dbtables['sector_defence'] ?? ($prefix . 'sector_defence'),
            TableEnum::Bounty => $dbtables['bounty'] ?? ($prefix . 'bounty'),
            TableEnum::Logs => $dbtables['logs'] ?? ($prefix . 'logs'),
        };
    }
}
