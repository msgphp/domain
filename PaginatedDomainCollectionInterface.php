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
interface PaginatedDomainCollectionInterface extends DomainCollectionInterface
{
    public function getOffset(): float;

    public function getLimit(): float;

    public function getCurrentPage(): float;

    public function getLastPage(): float;

    public function getTotalCount(): float;
}
