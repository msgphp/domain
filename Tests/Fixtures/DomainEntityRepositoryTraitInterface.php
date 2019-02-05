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

namespace MsgPhp\Domain\Tests\Fixtures;

use MsgPhp\Domain\DomainCollectionInterface;

interface DomainEntityRepositoryTraitInterface
{
    public function doFindAll(int $offset = 0, int $limit = 0): DomainCollectionInterface;

    public function doFindAllByFields(array $fields, int $offset = 0, int $limit = 0): DomainCollectionInterface;

    public function doFind($id);

    public function doFindByFields(array $fields);

    public function doExists($id): bool;

    public function doExistsByFields(array $fields): bool;

    public function doSave($entity): void;

    public function doDelete($entity): void;
}
