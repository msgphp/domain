<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Tests\Model;

use MsgPhp\Domain\Model\LastUpdatedAtField;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class LastUpdatedAtFieldTest extends TestCase
{
    public function testField(): void
    {
        self::assertSame($lastUpdatedAt = new \DateTimeImmutable(), (new TestLastUpdatedAtFieldModel($lastUpdatedAt))->getLastUpdatedAt());
    }
}

class TestLastUpdatedAtFieldModel
{
    use LastUpdatedAtField;

    public function __construct(\DateTimeInterface $lastUpdatedAt)
    {
        $this->lastUpdatedAt = $lastUpdatedAt;
    }
}
