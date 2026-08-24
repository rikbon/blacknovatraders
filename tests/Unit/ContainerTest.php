<?php

declare(strict_types=1);

namespace BNT\Test\Unit;

use PHPUnit\Framework\TestCase;
use BNT\Container;
use Psr\Container\NotFoundExceptionInterface;

final class ContainerTest extends TestCase
{
    public function testContainerStoresAndRetrievesAssets(): void
    {
        $container = new Container([
            'game_title' => 'BlackNova Traders',
            'version' => '1.0.0',
            'calculator' => function () {
                return new class {
                    public function add(int $a, int $b): int
                    {
                        return $a + $b;
                    }
                };
            },
        ]);

        $this->assertTrue($container->has('game_title'));
        $this->assertTrue($container->has('version'));
        $this->assertFalse($container->has('non_existent'));

        $this->assertSame('BlackNova Traders', $container->get('game_title'));
        $this->assertSame('1.0.0', $container->get('version'));
        $this->assertSame(42, $container->get('calculator')->add(20, 22));
    }

    public function testContainerThrowsNotFoundExceptionForMissingAsset(): void
    {
        $container = new Container([]);

        $this->expectException(NotFoundExceptionInterface::class);
        $container->get('missing_key');
    }
}
