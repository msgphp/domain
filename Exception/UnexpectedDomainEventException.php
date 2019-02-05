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

namespace MsgPhp\Domain\Exception;

use MsgPhp\Domain\Event\{DomainEventHandlerInterface, DomainEventInterface};

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class UnexpectedDomainEventException extends \RuntimeException implements DomainExceptionInterface
{
    public static function createForHandler(DomainEventHandlerInterface $handler, DomainEventInterface $event): self
    {
        return new self(sprintf('Domain event "%s" cannot be handled by "%s".', \get_class($event), \get_class($handler)));
    }
}
