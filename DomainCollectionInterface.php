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

namespace MsgPhp\Domain;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
interface DomainCollectionInterface extends \Countable, \IteratorAggregate
{
    public static function fromValue(?iterable $value): self;

    public function isEmpty(): bool;

    /**
     * @param mixed $element
     */
    public function contains($element): bool;

    /**
     * @param string|int $key
     */
    public function containsKey($key): bool;

    /**
     * @return mixed
     */
    public function first();

    /**
     * @return mixed
     */
    public function last();

    /**
     * @param string|int $key
     *
     * @return mixed
     */
    public function get($key);

    public function filter(callable $filter): self;

    public function slice(int $offset, int $limit = 0): self;

    public function map(callable $mapper): self;
}
