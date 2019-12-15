<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Tests\Model;

use MsgPhp\Domain\Event\Disable;
use MsgPhp\Domain\Event\Enable;
use MsgPhp\Domain\Model\CanBeEnabled;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class CanBeEnabledTest extends TestCase
{
    public function testEnable(): void
    {
        $model = new TestCanBeEnabledModel(false);

        self::assertFalse($model->isEnabled());

        $model->enable();

        self::assertTrue($model->isEnabled());
    }

    public function testDisable(): void
    {
        $model = new TestCanBeEnabledModel(true);

        self::assertTrue($model->isEnabled());

        $model->disable();

        self::assertFalse($model->isEnabled());
    }

    public function testHandleEnableEvent(): void
    {
        $model = new TestCanBeEnabledModel(false);

        self::assertTrue($model->onEnableEvent(new Enable()));
        self::assertTrue($model->isEnabled());
        self::assertFalse($model->onEnableEvent(new Enable()));
        self::assertTrue($model->isEnabled());
    }

    public function testHandleDisableEvent(): void
    {
        $model = new TestCanBeEnabledModel(true);

        self::assertTrue($model->onDisableEvent(new Disable()));
        self::assertFalse($model->isEnabled());
        self::assertFalse($model->onDisableEvent(new Disable()));
        self::assertFalse($model->isEnabled());
    }
}

class TestCanBeEnabledModel
{
    use CanBeEnabled {
        onDisableEvent as public;
        onEnableEvent as public;
    }

    public function __construct(bool $enabled)
    {
        $this->enabled = $enabled;
    }
}
