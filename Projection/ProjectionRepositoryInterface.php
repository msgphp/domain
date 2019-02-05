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

namespace MsgPhp\Domain\Projection;

use MsgPhp\Domain\PaginatedDomainCollectionInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
interface ProjectionRepositoryInterface
{
    /**
     * @return PaginatedDomainCollectionInterface|ProjectionDocument[]
     */
    public function findAll(string $type, int $offset = 0, int $limit = 0): PaginatedDomainCollectionInterface;

    public function find(string $type, string $id): ?ProjectionDocument;

    public function clear(string $type): void;

    public function save(ProjectionDocument $document): void;

    public function delete(string $type, string $id): void;
}
