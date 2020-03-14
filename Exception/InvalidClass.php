<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Exception;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class InvalidClass extends \LogicException implements DomainException
{
    public static function create(string $class): self
    {
        return new self('Class "'.$class.'" is invalid.');
    }

    public static function createForMethod(string $class, string $method): self
    {
        return new self('Class "'.$class.'" is invalid for method "'.$method.'".');
    }
}
