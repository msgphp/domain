<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Tests\Entity;

use MsgPhp\Domain\Entity\CreatedAtFieldTrait;
use PHPUnit\Framework\TestCase;

final class CreatedAtFieldTraitTest extends TestCase
{
    public function testField(): void
    {
        $object = $this->getObject($value = new \DateTime());

        $this->assertSame($value, $object->getCreatedAt());
    }

    private function getObject($value)
    {
        return new class ($value) {
            use CreatedAtFieldTrait;

            public function __construct($value)
            {
                $this->createdAt = $value;
            }
        };
    }
}
