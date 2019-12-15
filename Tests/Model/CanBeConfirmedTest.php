<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Tests\Model;

use MsgPhp\Domain\Event\Confirm;
use MsgPhp\Domain\Model\CanBeConfirmed;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class CanBeConfirmedTest extends TestCase
{
    public function testConfirm(): void
    {
        $model = new TestCanBeConfirmedModel('foo', null);

        self::assertSame('foo', $model->getConfirmationToken());
        self::assertNull($model->getConfirmedAt());
        self::assertFalse($model->isConfirmed());

        $model->confirm();

        self::assertNull($model->getConfirmationToken());
        self::assertInstanceOf(\DateTimeImmutable::class, $model->getConfirmedAt());
        self::assertTrue($model->isConfirmed());
    }

    public function testOnConfirmEvent(): void
    {
        $model = new TestCanBeConfirmedModel('foo', null);

        self::assertTrue($model->onConfirmEvent(new Confirm()));
        self::assertNull($prevToken = $model->getConfirmationToken());
        self::assertInstanceOf(\DateTimeImmutable::class, $model->getConfirmedAt());
        self::assertTrue($model->isConfirmed());
        self::assertFalse($model->onConfirmEvent(new Confirm()));
        self::assertTrue($model->isConfirmed());
    }
}

class TestCanBeConfirmedModel
{
    use CanBeConfirmed {
        onConfirmEvent as public;
    }

    public function __construct(?string $confirmationToken, ?\DateTimeInterface $confirmedAt)
    {
        $this->confirmationToken = $confirmationToken;
        $this->confirmedAt = $confirmedAt;
    }
}
