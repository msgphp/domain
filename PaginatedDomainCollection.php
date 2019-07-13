<?php

declare(strict_types=1);

namespace MsgPhp\Domain;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @template TKey of array-key
 * @template T
 * @extends DomainCollection<TKey, T>
 */
interface PaginatedDomainCollection extends DomainCollection
{
    public function getOffset(): float;

    public function getLimit(): float;

    public function getCurrentPage(): float;

    public function getLastPage(): float;

    public function getTotalCount(): float;
}
