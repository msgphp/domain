<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Message;

use MsgPhp\Domain\Factory\DomainObjectFactoryInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait MessageDispatchingTrait
{
    /**
     * @var DomainObjectFactoryInterface
     */
    private $factory;

    /**
     * @var DomainMessageBusInterface
     */
    private $bus;

    public function __construct(DomainObjectFactoryInterface $factory, DomainMessageBusInterface $bus)
    {
        $this->factory = $factory;
        $this->bus = $bus;
    }

    /**
     * @psalm-param class-string $class
     */
    private function dispatch(string $class, array $context = []): void
    {
        $this->bus->dispatch($this->factory->create($class, $context));
    }
}
