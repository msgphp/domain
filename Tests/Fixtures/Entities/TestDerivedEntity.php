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

namespace MsgPhp\Domain\Tests\Fixtures\Entities;

use MsgPhp\Domain\DomainId;

/**
 * @Doctrine\ORM\Mapping\Entity()
 */
class TestDerivedEntity extends BaseTestEntity
{
    /**
     * @var TestEntity
     * @Doctrine\ORM\Mapping\Id()
     * @Doctrine\ORM\Mapping\OneToOne(targetEntity="TestEntity", cascade={"all"})
     */
    public $entity;

    public static function getIdFields(): array
    {
        return ['entity'];
    }

    public static function getFieldValues(): array
    {
        static $entity;
        if (null === $entity) {
            $entity = TestEntity::create(['intField' => 0, 'boolField' => true]);

            // https://github.com/doctrine/doctrine2/issues/4584
            $entity->setId(new DomainId('IRRELEVANT'));
        }

        return [
            'entity' => [$entity],
        ];
    }
}
