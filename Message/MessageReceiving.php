<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Message;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @internal
 */
interface MessageReceiving
{
    public function onMessageReceived(object $message): void;
}
