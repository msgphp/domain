<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Tests\Infra\Doctrine;

use MsgPhp\Domain\Infra\Doctrine\DomainIdType;
use MsgPhp\Domain\Infra\Doctrine\Test\EntityManagerTrait as BaseEntityManagerTrait;

trait EntityManagerTrait
{
    use BaseEntityManagerTrait;

    protected static function createSchema(): bool
    {
        return true;
    }

    protected static function getEntityPaths(): iterable
    {
        yield \dirname(__DIR__, 2).'/Fixtures/Entities';
    }

    protected static function getTypes(): iterable
    {
        yield DomainIdType::class;
    }
}
