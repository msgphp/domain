<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Event;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait DomainEventHandlerTrait
{
    public function handleEvent(DomainEvent $event): bool
    {
        $method = 'on'.(false === ($pos = strrpos($class = \get_class($event), '\\')) ? $class : substr($class, $pos + 1)).'Event';

        if (!method_exists($this, $method)) {
            throw new \LogicException('Domain event "'.\get_class($event).'" cannot be handled by "'.static::class.'".');
        }

        return $this->{$method}($event);
    }
}
