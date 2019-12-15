<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Tests\Model;

use MsgPhp\Domain\Model\CreatedAtField;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class CreatedAtFieldTest extends TestCase
{
    public function testField(): void
    {
        self::assertSame($createdAt = new \DateTimeImmutable(), (new TestCreatedAtFieldModel($createdAt))->getCreatedAt());
    }
}

class TestCreatedAtFieldModel
{
    use CreatedAtField;

    public function __construct(\DateTimeInterface $createdAt)
    {
        $this->createdAt = $createdAt;
    }
}
