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

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class UnknownCollectionElementException extends \OutOfBoundsException implements DomainExceptionInterface
{
    /**
     * @param string|int $key
     */
    public static function createForKey($key): self
    {
        return new self(sprintf('Collection element with key "%s" does not exists.', (string) $key));
    }
}
