<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Tests\Fixtures\Entities;

/**
 * @Doctrine\ORM\Mapping\Entity()
 */
class TestChildEntity extends TestParentEntity
{
    /**
     * @var null|string
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
