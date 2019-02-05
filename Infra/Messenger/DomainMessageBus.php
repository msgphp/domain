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

namespace MsgPhp\Domain\Infra\Messenger;

use MsgPhp\Domain\Message\DomainMessageBusInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class DomainMessageBus implements DomainMessageBusInterface
{
    /**
     * @var MessageBusInterface
     */
    private $commandBus;

    /**
     * @var MessageBusInterface
     */
    private $eventBus;

    /**
     * @psalm-var array<class-string, int>
     *
     * @var int[]
     */
    private $eventClasses;

    /**
     * @psalm-param array<int, class-string> $eventClasses
     *
     * @param string[] $eventClasses
     */
    public function __construct(MessageBusInterface $commandBus, MessageBusInterface $eventBus, array $eventClasses = [])
    {
        $this->commandBus = $commandBus;
        $this->eventBus = $eventBus;
        $this->eventClasses = array_flip($eventClasses);
    }

    public function dispatch($message): void
    {
        if (isset($this->eventClasses[$message instanceof Envelope ? \get_class($message->getMessage()) : \get_class($message)])) {
            $this->eventBus->dispatch($message);
        } else {
            $this->commandBus->dispatch($message);
        }
    }
}
