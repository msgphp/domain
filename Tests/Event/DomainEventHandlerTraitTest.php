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

namespace MsgPhp\Domain\Tests\Event;

use MsgPhp\Domain\Event\{DomainEventHandlerInterface, DomainEventHandlerTrait, DomainEventInterface};
use MsgPhp\Domain\Exception\UnexpectedDomainEventException;
use PHPUnit\Framework\TestCase;

final class DomainEventHandlerTraitTest extends TestCase
{
    public function testHandleEvent(): void
    {
        $object = $this->getObject();

        self::assertTrue($object->handleEvent($event = new TestEvent()));
        self::assertTrue($event->handled);
        self::assertTrue($object->handleEvent($event = new TestEventDifferentSuffix()));
        self::assertTrue($event->handled);

        $event = $this->getMockBuilder(DomainEventInterface::class)
            ->setMockClassName('MsgPhp_Test_Root_Event')
            ->getMock()
        ;
        self::assertFalse($object->handleEvent($event));
    }

    public function testHandleEventWithUnknownEvent(): void
    {
        $object = $this->getObject();

        $this->expectException(UnexpectedDomainEventException::class);

        $object->handleEvent($this->createMock(DomainEventInterface::class));
    }

    private function getObject(): DomainEventHandlerInterface
    {
        return new class() implements DomainEventHandlerInterface {
            use DomainEventHandlerTrait;

            private function handleTestEvent(TestEvent $event): bool
            {
                $event->handled = true;

                return true;
            }

            private function handleTestEventDifferentSuffixEvent(TestEventDifferentSuffix $event): bool
            {
                $event->handled = true;

                return true;
            }

            private function handleMsgPhp_Test_Root_Event(DomainEventInterface $event): bool
            {
                return false;
            }
        };
    }
}

class TestEvent implements DomainEventInterface
{
    public $handled = false;
}

class TestEventDifferentSuffix extends TestEvent
{
}
