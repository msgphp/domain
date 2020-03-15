<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Tests\Infrastructure\Uid;

use MsgPhp\Domain\GenericDomainId;
use MsgPhp\Domain\Infrastructure\Uid\DomainUuid;
use MsgPhp\Domain\Tests\Fixtures\StringableValue;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * @internal
 */
final class DomainUuidTest extends TestCase
{
    public function testFromValue(): void
    {
        $uuid = Uuid::fromString(Uuid::NIL);

        self::assertInstanceOf(DomainUuid::class, DomainUuid::fromValue(null));
        self::assertSame((array) new DomainUuid($uuid), (array) DomainUuid::fromValue($uuid));
        self::assertSame(Uuid::NAMESPACE_DNS, DomainUuid::fromValue(Uuid::NAMESPACE_DNS)->toString());
        self::assertSame(Uuid::NIL, DomainUuid::fromValue(new StringableValue(Uuid::NIL))->toString());
        self::assertSame(Uuid::NIL, DomainUuid::fromValue(null)->toString());
    }

    public function testFromValueWithInvalidUuid(): void
    {
        $this->expectException(\LogicException::class);

        DomainUuid::fromValue('');
    }

    public function testFromInvalidValue(): void
    {
        $this->expectException(\LogicException::class);

        DomainUuid::fromValue(true);
    }

    public function testIsNil(): void
    {
        self::assertFalse((new DomainUuid())->isNil());
        self::assertTrue((new DomainUuid(Uuid::fromString(Uuid::NIL)))->isNil());
    }

    public function testEquals(): void
    {
        $id = new DomainUuid(Uuid::fromString(Uuid::NIL));

        self::assertTrue($id->equals($id));
        self::assertTrue($id->equals(new DomainUuid(Uuid::fromString(Uuid::NIL))));
        self::assertFalse($id->equals(new DomainUuid()));
        self::assertFalse($id->equals(Uuid::NIL));
        self::assertFalse($id->equals(new \stdClass()));
        self::assertFalse($id->equals(new GenericDomainId(Uuid::NIL)));
    }

    public function testToString(): void
    {
        $id = new DomainUuid(Uuid::fromString(Uuid::NIL));

        self::assertSame(Uuid::NIL, $id->toString());
        self::assertSame(Uuid::NIL, (string) $id);
        self::assertNotSame((new DomainUuid())->toString(), (new DomainUuid())->toString());
        self::assertNotSame((string) new DomainUuid(), (string) new DomainUuid());
    }

    public function testSerialize(): void
    {
        $id = new DomainUuid(Uuid::fromString(Uuid::NIL));

        self::assertSame($id->toString(), (string) unserialize(serialize($id)));
    }
}
