<?php

declare(strict_types=1);

namespace MsgPhp\Domain;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @template TKey of array-key
 * @template T
 * @implements PaginatedDomainCollection<TKey,T>
 */
final class GenericPaginatedDomainCollection implements PaginatedDomainCollection
{
    /** @var DomainCollection<TKey, T> */
    private $collection;
    /** @var float */
    private $offset;
    /** @var float */
    private $limit;
    /** @var null|float */
    private $count;
    /** @var null|float */
    private $totalCount;

    /**
     * @param iterable<TKey, T> $elements
     */
    public function __construct(iterable $elements, float $offset = .0, float $limit = .0, ?float $count = null, ?float $totalCount = null)
    {
        $this->collection = $elements instanceof DomainCollection ? $elements : GenericDomainCollection::fromValue($elements);
        $this->offset = $offset;
        $this->limit = $limit;
        $this->count = $count;
        $this->totalCount = $totalCount;
    }

    public static function fromValue(?iterable $value): DomainCollection
    {
        return new self($value ?? []);
    }

    public function getIterator(): \Traversable
    {
        return $this->collection->getIterator();
    }

    public function isEmpty(): bool
    {
        return $this->collection->isEmpty();
    }

    public function contains($element): bool
    {
        return $this->collection->contains($element);
    }

    public function containsKey($key): bool
    {
        return $this->collection->containsKey($key);
    }

    public function first()
    {
        return $this->collection->first();
    }

    public function last()
    {
        return $this->collection->last();
    }

    public function get($key)
    {
        return $this->collection->get($key);
    }

    public function filter(callable $filter): DomainCollection
    {
        return $this->collection->filter($filter);
    }

    public function slice(int $offset, int $limit = 0): DomainCollection
    {
        return $this->collection->slice($offset, $limit);
    }

    public function map(callable $mapper): DomainCollection
    {
        return $this->collection->map($mapper);
    }

    public function count(): int
    {
        if (null === $this->count) {
            return \count($this->collection);
        }

        return (int) $this->count;
    }

    public function getOffset(): float
    {
        return $this->offset;
    }

    public function getLimit(): float
    {
        return $this->limit;
    }

    public function getCurrentPage(): float
    {
        if (0 >= $this->limit) {
            return 1.;
        }

        return floor($this->offset / $this->limit) + 1.;
    }

    public function getLastPage(): float
    {
        if (0 >= $this->limit) {
            return 1.;
        }

        return ceil($this->getTotalCount() / $this->limit) ?: 1.;
    }

    public function getTotalCount(): float
    {
        return $this->totalCount ?? (float) \count($this);
    }
}
