<?php

declare(strict_types=1);

/*
 * This file is part of the MsgPHP package.
 *
 * (c) Roland Franssen <franssen.roland@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
