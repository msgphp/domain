<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Exception;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class EntityNotFoundException extends \RuntimeException implements DomainExceptionInterface
{
    public static function createForFields(string $entity, array $fields): self
    {
        return new self(sprintf('Entity "%s" with fields matching %s cannot be found.', $entity, json_encode($fields)));
    }
}
