<?php

declare(strict_types=1);

namespace BNT\Test\Unit;

use PHPUnit\Framework\TestCase;
use BNT\Enum\TableEnum;
use BNT\Enum\BalanceEnum;

final class EnumTest extends TestCase
{
    public function testTableEnumOutputsValidDatabaseNames(): void
    {
        $this->assertSame('bnt_ships', TableEnum::Ships->toDb());
        $this->assertSame('bnt_planets', TableEnum::Planets->toDb());
        $this->assertSame('bnt_universe', TableEnum::Sectors->toDb());
        $this->assertSame('bnt_zones', TableEnum::Zones->toDb());
    }

    public function testBalanceEnumValues(): void
    {
        $this->assertSame(2500, BalanceEnum::max_turns->val());
        $this->assertSame(1000, BalanceEnum::start_credits->val());
        $this->assertSame(10, BalanceEnum::start_fighters->val());
        $this->assertSame(500, BalanceEnum::start_energy->val());
        $this->assertSame(100, BalanceEnum::start_armor->val());
    }
}
