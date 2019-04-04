<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Tests\Event;

use MsgPhp\Domain\Event\DomainEvent;
use MsgPhp\Domain\Event\DomainEventHandler;
use MsgPhp\Domain\Event\DomainEventHandlerTrait;
use PHPUnit\Framework\TestCase;

final class DomainEventHandlerTraitTest extends TestCase
{
    public function testHandleEvent(): void
    {
        self::assertTrue($this->getObject()->handleEvent(new TestAction()));
    }

    public function testHandleRootEvent(): void
    {
        self::assertFalse($this->getObject()->handleEvent($this->getMockBuilder(DomainEvent::class)
            ->setMockClassName('MsgPhp_Test_Action')
            ->getMock()))
        ;
    }

    public function testHandleEventWithUnknownEvent(): void
    {
        $object = $this->getObject();

        $this->expectException(\LogicException::class);

        $object->handleEvent($this->createMock(DomainEvent::class));
    }

    private function getObject(): DomainEventHandler
    {
        return new class() implements DomainEventHandler {
            use DomainEventHandlerTrait;

            private function onTestActionEvent(TestAction $event): bool
            {
                return true;
            }

            private function onMsgPhp_Test_ActionEvent($event): bool
            {
                return false;
            }
        };
    }
}

class TestAction implements DomainEvent
{
}
