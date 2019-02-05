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

namespace MsgPhp\Domain\Infra\Console;

use MsgPhp\Domain\Message\MessageReceivingInterface;
use Symfony\Component\Console\Event\ConsoleCommandEvent;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @internal
 */
final class MessageReceiver
{
    /**
     * @var MessageReceivingInterface|null
     */
    private $receiver;

    /**
     * @param object $message
     */
    public function receive($message): void
    {
        if (null === $this->receiver) {
            return;
        }

        $this->receiver->onMessageReceived($message);
    }

    public function onCommand(ConsoleCommandEvent $event): void
    {
        $this->receiver = ($command = $event->getCommand()) instanceof MessageReceivingInterface ? $command : null;
    }

    public function onTerminate(): void
    {
        $this->receiver = null;
    }
}
