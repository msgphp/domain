<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Infra\Doctrine\Mapping;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
interface ObjectFieldMappingProviderInterface
{
    public static function getObjectFieldMapping(): array;
}
