<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Infra\Bundle;

use MsgPhp\Domain\{CommandBusInterface, EventBusInterface};
use MsgPhp\Domain\Infra\SimpleBus\{DomainCommandBus, DomainEventBus};
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\ref;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class ServiceConfigHelper
{
    public static function configureSimpleBus(ContainerConfigurator $container): void
    {
        static $configured = false;

        if ($configured) {
            return;
        }

        $container->services()
            ->defaults()
                ->private()
            ->set(DomainCommandBus::class)
                ->args([ref('command_bus')])
            ->alias(CommandBusInterface::class, DomainCommandBus::class)
            ->set(DomainEventBus::class)
                ->args([ref('event_bus')])
            ->alias(EventBusInterface::class, DomainEventBus::class)
        ;

        $configured = true;
    }

    private function __construct()
    { }
}
