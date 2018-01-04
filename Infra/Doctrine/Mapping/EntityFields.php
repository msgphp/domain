<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Infra\Doctrine\Mapping;

use MsgPhp\Domain\Entity\Fields\{CreatedAtField, EnabledField, LastUpdatedAtField};
use MsgPhp\User\Entity\Fields\UserField;
use MsgPhp\User\Entity\User;

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
            UserField::class => [ // @fixme move to User domain
                'user' => [
                    'type' => self::TYPE_MANY_TO_ONE,
                    'targetEntity' => User::class,
                    'joinColumns' => [
                        ['nullable' => false],
                    ],
                ],
            ],
        ];
    }
}
