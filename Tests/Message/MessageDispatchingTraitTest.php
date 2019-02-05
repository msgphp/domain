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

namespace MsgPhp\Domain\Tests\Message;

use MsgPhp\Domain\Factory\DomainObjectFactoryInterface;
use MsgPhp\Domain\Message\{DomainMessageBusInterface, MessageDispatchingTrait};
use PHPUnit\Framework\TestCase;

final class MessageDispatchingTraitTest extends TestCase
{
    public function testDispatch(): void
    {
        $factory = $this->createMock(DomainObjectFactoryInterface::class);
        $factory->expects(self::once())
            ->method('create')
            ->with('class', ['context'])
            ->willReturn($message = new \stdClass())
        ;
        $bus = $this->createMock(DomainMessageBusInterface::class);
        $bus->expects(self::once())
            ->method('dispatch')
            ->with($message)
        ;

        self::assertNull($this->getObject($factory, $bus)->dispatch('class', ['context']));
    }

    /**
     * @return object
     */
    private function getObject(DomainObjectFactoryInterface $factory, DomainMessageBusInterface $bus)
    {
        return new class($factory, $bus) {
            use MessageDispatchingTrait {
                dispatch as public;
            }
        };
    }
}
