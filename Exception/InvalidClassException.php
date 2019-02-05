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
final class InvalidClassException extends \LogicException implements DomainExceptionInterface
{
    public static function create(string $class): self
    {
        return new self(sprintf('Invalid class "%s" detected.', $class));
    }

    public static function createForMethod(string $class, string $method): self
    {
        return new self(sprintf('Invalid class "%s" detected for method "%s".', $class, $method));
    }
}
