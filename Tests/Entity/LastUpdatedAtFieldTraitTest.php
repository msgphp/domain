<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Tests\Entity;

use MsgPhp\Domain\Entity\LastUpdatedAtFieldTrait;
use PHPUnit\Framework\TestCase;

final class LastUpdatedAtFieldTraitTest extends TestCase
{
    public function testField(): void
    {
        $object = $this->getObject($value = new \DateTime());

        $this->assertSame($value, $object->getLastUpdatedAt());
    }

    private function getObject($value)
    {
        return new class($value) {
            use LastUpdatedAtFieldTrait;

            public function __construct($value)
            {
                $this->lastUpdatedAt = $value;
            }
        };
    }
}
