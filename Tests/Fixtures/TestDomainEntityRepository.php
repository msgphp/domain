<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Tests\Fixtures;

use MsgPhp\Domain\DomainCollection;

/**
 * @template T of object
 */
interface TestDomainEntityRepository
{
    /**
     * @return DomainCollection<T>
     */
    public function findAll(int $offset = 0, int $limit = 0): DomainCollection;

    /**
     * @return DomainCollection<T>
     */
    public function findAllByFields(array $fields, int $offset = 0, int $limit = 0): DomainCollection;

    /**
     * @param mixed $id
     *
     * @return T
     */
    public function find($id): object;

    /**
     * @return T
     */
    public function findByFields(array $fields): object;

    /**
     * @param mixed $id
     */
    public function exists($id): bool;

    public function existsByFields(array $fields): bool;

    /**
     * @param T $entity
     */
    public function save(object $entity): void;

    /**
     * @param T $entity
     */
    public function delete(object $entity): void;
}
