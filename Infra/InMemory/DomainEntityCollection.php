<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Infra\InMemory;

use MsgPhp\Domain\Entity\EntityCollectionInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class DomainEntityCollection implements EntityCollectionInterface
{
    private $elements;

    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->elements);
    }

    public function isEmpty(): bool
    {
        return !$this->elements;
    }

    public function contains($entity): bool
    {
        return in_array($entity, $this->elements, true);
    }

    public function first()
    {
        return reset($this->elements);
    }

    public function last()
    {
        return end($this->elements);
    }

    public function filter(callable $filter): EntityCollectionInterface
    {
        return new self(array_filter($this->elements, $filter));
    }

    public function map(callable $mapper): array
    {
        return array_map($mapper, $this->elements);
    }

    public function count(): int
    {
        return count($this->elements);
    }
}
