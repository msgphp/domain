<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Infrastructure\Messenger\Test;

use MsgPhp\Domain\Infrastructure\Messenger\DomainMessageBus;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait MessageBusTestTrait
{
    /** @var MessageBusInterface */
    private static $bus;
    /** @var array<class-string, array<int, object>> */
    private static $dispatchedMessages = [];

    /**
     * @beforeClass
     */
    public static function initBus(): void
    {
        self::$bus = new MessageBus([new HandleMessageMiddleware(new HandlersLocator(['*' => [static function ($message): void {
            self::$dispatchedMessages[$messageClass = \get_class($message)][] = $message;

            foreach (self::getMessageHandlers() as $class => $handler) {
                if ($class === $messageClass) {
                    $handler($message);
                }
            }
        }]]))]);
    }

    /**
     * @afterClass
     */
    public static function destroyBus(): void
    {
        self::$bus = null;
    }

    /**
     * @before
     * @after
     */
    public static function cleanBus(): void
    {
        self::$dispatchedMessages = [];
    }

    abstract protected static function getMessageHandlers(): iterable;

    private static function createDomainMessageBus(): DomainMessageBus
    {
        return new DomainMessageBus(self::$bus, self::$bus);
    }

    /**
     * @param class-string $class
     */
    private static function assertMessageIsDispatched(string $class, callable $assertion = null): void
    {
        if (!isset(self::$dispatchedMessages[$class])) {
            throw new \LogicException('Message "'.$class.'" is not dispatched, but was expected to.');
        }

        if (null === $assertion) {
            return;
        }

        foreach (self::$dispatchedMessages[$class] as $i => $message) {
            $assertion($message, $i);
        }
    }

    /**
     * @param class-string $class
     */
    private static function assertMessageIsDispatchedOnce(string $class, callable $assertion = null): void
    {
        if (1 !== $count = \count(self::$dispatchedMessages[$class] ?? [])) {
            throw new \LogicException('Message "'.$class.'" is dispatched '.$count.' times, but was expected only once.');
        }

        self::assertMessageIsDispatched($class, $assertion);
    }

    /**
     * @param class-string $class
     */
    private static function assertMessageIsNotDispatched(string $class): void
    {
        if (isset(self::$dispatchedMessages[$class])) {
            throw new \LogicException('Message "'.$class.'" is dispatched, but was not expected to.');
        }
    }
}
