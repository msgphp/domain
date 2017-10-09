<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Infra\InMemory;

use MsgPhp\Domain\DomainIdInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class DomainId implements DomainIdInterface
{
    private $id;

    public function __construct(string $id = null)
    {
        $this->id = $id ?? bin2hex(random_bytes(8));
    }

    public function toString(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->id;
    }

    public function serialize(): string
    {
        return serialize($this->id);
    }

    public function unserialize($serialized): void
    {
        $this->id = unserialize($serialized);
    }

    public function jsonSerialize(): string
    {
        return $this->id;
    }

    public function equals(DomainIdInterface $id): bool
    {
        return $this->id === $id->toString();
    }
}
