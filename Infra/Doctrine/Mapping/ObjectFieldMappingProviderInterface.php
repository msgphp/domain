<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Infra\Doctrine\Mapping;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
interface ObjectFieldMappingProviderInterface
{
    public const TYPE_EMBEDDED = 'embedded';
    public const TYPE_MANY_TO_MANY = 'many_to_many';
    public const TYPE_MANY_TO_ONE = 'many_to_one';
    public const TYPE_ONE_TO_MANY = 'one_to_many';
    public const TYPE_ONE_TO_ONE = 'one_to_one';

    public static function getObjectFieldMapping(): array;
}
