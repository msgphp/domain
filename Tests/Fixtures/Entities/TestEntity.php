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

use MsgPhp\Domain\{DomainId, DomainIdInterface};

/**
 * @Doctrine\ORM\Mapping\Entity()
 */
class TestEntity extends BaseTestEntity
{
    /**
     * @var DomainIdInterface|null
     * @Doctrine\ORM\Mapping\Id()
     * @Doctrine\ORM\Mapping\GeneratedValue()
     * @Doctrine\ORM\Mapping\Column(type="msgphp_domain_id")
     */
    private $id;

    /**
     * @var string|null
     * @Doctrine\ORM\Mapping\Column(type="string", nullable=true)
     */
    public $strField;

    /**
     * @var int
     * @Doctrine\ORM\Mapping\Column(type="integer", nullable=false)
     */
    public $intField;

    /**
     * @var float|null
     * @Doctrine\ORM\Mapping\Column(type="float", nullable=true)
     */
    public $floatField;

    /**
     * @var bool
     * @Doctrine\ORM\Mapping\Column(type="boolean", nullable=false)
     */
    public $boolField;

    public static function getIdFields(): array
    {
        return ['id'];
    }

    public static function getFieldValues(): array
    {
        return [
            'strField' => [null, '', 'foo'],
            'intField' => [0, 1],
            'floatField' => [null, .0, -1.23],
            'boolField' => [true, false],
        ];
    }

    final public function setId(DomainIdInterface $id): void
    {
        $this->id = $id;
    }

    final public function getId(): DomainIdInterface
    {
        return $this->id ?? ($this->id = new DomainId());
    }
}
