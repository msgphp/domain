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
 */
class TestChildEntity extends TestParentEntity
{
    /**
     * @var string|null
     * @Doctrine\ORM\Mapping\Column(nullable=true)
     */
    public $childField;

    public static function getFieldValues(): array
    {
        return parent::getFieldValues() + [
            'childField' => [null, 'bar'],
        ];
    }
}
