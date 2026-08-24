<?php

declare(strict_types=1);

namespace BNT;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\StoppableEventInterface;
use BNT\UnitInterface;
use BNT\FromToInterface;

class EventDispatcher implements EventDispatcherInterface
{

    use Traits\ContainerTrait;

    public function dispatch(object $event): object
    {
        $events = $this->container->get('events');
        $class = get_class($event);
        $handlers = [];

        if (!empty($events[$class])) {
            $handlers = $events[$class];
        } elseif (isset($event->name) && !empty($events[$event->name])) {
            $handlers = $events[$event->name];
        } else {
            while (true) {
                $class = get_parent_class($class);

                if ($class === false) {
                    break;
                }

                if (!empty($events[$class])) {
                    $handlers = $events[$class];
                    break;
                }
            }
        }

        foreach ($handlers as $handler) {
            if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
                break;
            }

            if (is_callable($handler)) {
                $handler($event);
                continue;
            }

            if (is_string($handler) && class_exists($handler)) {
                $handlerObject = new $handler($this->container);

                if ($handlerObject instanceof UnitInterface && $event instanceof FromToInterface) {
                    $event->to($handlerObject);
                    $handlerObject->serve();
                    $event->from($handlerObject);
                }
            }
        }

        return $event;
    }

}
