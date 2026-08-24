<?php

declare(strict_types=1);

namespace BNT\Test\Unit;

use PHPUnit\Framework\TestCase;
use BNT\Ship\Entity\Ship;

final class ShipEntityTest extends TestCase
{
    public function testShipInitializationAndDefaults(): void
    {
        $ship = new Ship();
        $ship->ship_id = 1;
        $ship->ship_name = 'USS Defiant';
        $ship->character_name = 'Benjamin Sisko';
        $ship->email = 'sisko@deepspace9.org';
        $ship->credits = 10000;
        $ship->turns = 2500;

        $this->assertSame(1, $ship->ship_id);
        $this->assertSame('USS Defiant', $ship->ship_name);
        $this->assertSame('Benjamin Sisko', $ship->character_name);
        $this->assertSame(10000, $ship->credits);
        $this->assertSame(2500, $ship->turns);
        $this->assertFalse($ship->ship_destroyed);
    }

    public function testShipPasswordHashingAndVerification(): void
    {
        $ship = new Ship();
        $ship->password('Federation2026!');

        $this->assertNotEmpty($ship->password);
        $this->assertNotSame('Federation2026!', $ship->password);
        $this->assertTrue(password_verify('Federation2026!', $ship->password));
        $this->assertFalse(password_verify('WrongPassword', $ship->password));
    }

    public function testShipIdentityAndTeamAffiliation(): void
    {
        $ship1 = new Ship();
        $ship1->ship_id = 10;
        $ship1->team = 5;

        $ship2 = new Ship();
        $ship2->ship_id = 10;
        $ship2->team = 5;

        $ship3 = new Ship();
        $ship3->ship_id = 20;
        $ship3->team = 5;

        $this->assertTrue($ship1->isMe($ship2));
        $this->assertFalse($ship1->isMe($ship3));
        $this->assertTrue($ship1->isMyTeam($ship3));
    }
}
