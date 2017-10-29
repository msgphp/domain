<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Exception;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class UnknownEntityException extends \RuntimeException implements DomainExceptionInterface
{
    public static function create(string $entity): self
    {
        return new self(sprintf('Unknown entity "%s" detected.', $entity));
    }
}
