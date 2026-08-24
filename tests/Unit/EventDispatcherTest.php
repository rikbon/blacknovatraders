<?php

declare(strict_types=1);

namespace BNT\Test\Unit;

use PHPUnit\Framework\TestCase;
use BNT\Container;
use BNT\EventDispatcher;

final class EventDispatcherTest extends TestCase
{
    public function testEventDispatcherExecutesListeners(): void
    {
        $executed = false;
        $eventData = null;

        $container = new Container([
            'events' => [
                'test.custom_event' => [
                    function (object $event) use (&$executed, &$eventData) {
                        $executed = true;
                        $eventData = $event;
                    },
                ],
            ],
        ]);

        $dispatcher = new EventDispatcher($container);

        $dummyEvent = new class {
            public string $name = 'test.custom_event';
            public string $payload = 'supernova';
        };

        $result = $dispatcher->dispatch($dummyEvent);

        $this->assertTrue($executed);
        $this->assertSame($dummyEvent, $result);
        $this->assertSame('supernova', $eventData->payload);
    }
}
