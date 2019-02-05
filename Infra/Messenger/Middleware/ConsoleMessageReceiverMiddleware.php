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

namespace MsgPhp\Domain\Infra\Messenger\Middleware;

use MsgPhp\Domain\Infra\Console\MessageReceiver;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @internal
 */
final class ConsoleMessageReceiverMiddleware implements MiddlewareInterface
{
    /**
     * @var MessageReceiver
     */
    private $receiver;

    public function __construct(MessageReceiver $receiver)
    {
        $this->receiver = $receiver;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $this->receiver->receive($envelope->getMessage());

        return $stack->next()->handle($envelope, $stack);
    }
}
