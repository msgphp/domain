<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Infra\Bundle;

use MsgPhp\Domain\{CommandBusInterface, EventBusInterface};
use MsgPhp\Domain\Infra\SimpleBus\{DomainCommandBus, DomainEventBus};
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class ServiceConfigHelper
{
    public static function configureSimpleBus(ContainerBuilder $container): void
    {
        if (!$container->has(CommandBusInterface::class)) {
            if (!$container->has(DomainCommandBus::class)) {
                $container->register(DomainCommandBus::class)
                    ->setPublic(false)
                    ->addArgument(new Reference('command_bus'))
                ;
            }

            $container->setAlias(CommandBusInterface::class, new Alias(DomainCommandBus::class, false));
        }

        if (!$container->has(EventBusInterface::class)) {
            if (!$container->has(DomainEventBus::class)) {
                $container->register(DomainEventBus::class)
                    ->setPublic(false)
                    ->addArgument(new Reference('event_bus'))
                ;
            }

            $container->setAlias(EventBusInterface::class, new Alias(DomainEventBus::class, false));
        }
    }

    private function __construct()
    { }
}
