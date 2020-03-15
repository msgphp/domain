<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Tests\Model;

use MsgPhp\Domain\Model\IntIdentity;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class IntIdentityTest extends TestCase
{
    public function testIdentity(): void
    {
        self::assertTrue((new TestIntIdentityModel(null))->getId()->isNil());
        self::assertSame('1', (new TestIntIdentityModel(1))->getId()->toString());
    }
}

class TestIntIdentityModel
{
    use IntIdentity;

    public function __construct(?int $id)
    {
        $this->id = $id;
    }
}
