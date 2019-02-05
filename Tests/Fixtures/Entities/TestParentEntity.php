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

/**
 * @Doctrine\ORM\Mapping\Entity()
 * @Doctrine\ORM\Mapping\InheritanceType("JOINED")
 * @Doctrine\ORM\Mapping\DiscriminatorColumn(name="discriminator", type="string")
 * @Doctrine\ORM\Mapping\DiscriminatorMap({"parent" = "TestParentEntity", "child" = "TestChildEntity"})
 */
class TestParentEntity extends BaseTestEntity
{
    /**
     * @Doctrine\ORM\Mapping\Id()
     * @Doctrine\ORM\Mapping\Column()
     */
    public $id;

    /**
     * @var string|null
     * @Doctrine\ORM\Mapping\Column(nullable=true)
     */
    public $parentField;

    public static function getIdFields(): array
    {
        return ['id'];
    }

    public static function getFieldValues(): array
    {
        return [
            'id' => ['foo'],
            'parentField' => [null, 'foo'],
        ];
    }
}
