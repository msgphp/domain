<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Infra\Doctrine\Mapping;

use MsgPhp\Domain\Entity\Fields\{CreatedAtField, EnabledField, LastUpdatedAtField};

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @internal
 */
final class EntityFields implements ObjectFieldMappingProviderInterface
{
    public static function getObjectFieldMapping(): array
    {
        return [
            CreatedAtField::class => [
                'createdAt' => [
                    'type' => 'datetime',
                ],
            ],
            EnabledField::class => [
                'enabled' => [
                    'type' => 'boolean',
                ],
            ],
            LastUpdatedAtField::class => [
                'lastUpdatedAt' => [
                    'type' => 'datetime',
                ],
            ],
        ];
    }
}
