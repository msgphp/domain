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

namespace MsgPhp\Domain\Tests\Entity\Features;

use MsgPhp\Domain\Entity\Features\CanBeEnabled;
use MsgPhp\Domain\Event\{DisableEvent, EnableEvent};
use PHPUnit\Framework\TestCase;

final class CanBeEnabledTest extends TestCase
{
    public function testEnable(): void
    {
        $object = $this->getObject(false);

        self::assertFalse($object->isEnabled());

        $object->enable();

        self::assertTrue($object->isEnabled());
    }

    public function testDisable(): void
    {
        $object = $this->getObject(true);

        self::assertTrue($object->isEnabled());

        $object->disable();

        self::assertFalse($object->isEnabled());
    }

    public function testHandleEnableEvent(): void
    {
        $object = $this->getObject(false);

        self::assertTrue($object->handleEnableEvent($this->createMock(EnableEvent::class)));
        self::assertTrue($object->isEnabled());
        self::assertFalse($object->handleEnableEvent($this->createMock(EnableEvent::class)));
        self::assertTrue($object->isEnabled());
    }

    public function testHandleDisableEvent(): void
    {
        $object = $this->getObject(true);

        self::assertTrue($object->handleDisableEvent($this->createMock(DisableEvent::class)));
        self::assertFalse($object->isEnabled());
        self::assertFalse($object->handleDisableEvent($this->createMock(DisableEvent::class)));
        self::assertFalse($object->isEnabled());
    }

    /**
     * @return object
     */
    private function getObject($value)
    {
        return new class($value) {
            use CanBeEnabled {
                handleDisableEvent as public;
                handleEnableEvent as public;
            }

            public function __construct($value)
            {
                $this->enabled = $value;
            }
        };
    }
}
