<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Infra\Bundle;

use MsgPhp\Domain\{
    CommandBusInterface, Entity\ClassMappingEntityFactory, Entity\EntityFactoryInterface, EventBusInterface
};
use MsgPhp\Domain\Infra\SimpleBus\{DomainCommandBus, DomainEventBus};
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class ServiceConfigHelper
{
    public static function configureEntityFactory(ContainerBuilder $container, array $mapping, array $idMapping): void
    {
        if (!$container->hasDefinition('msgphp.entity_factory')) {
            $container->register('msgphp.entity_factory', ClassMappingEntityFactory::class)
                ->setArgument('$mapping', $mapping)
                ->setArgument('$idMapping', $idMapping)
            ;
        } else {
            ($def = $container->getDefinition('msgphp.entity_factory.inner'))
                ->setArgument('$mapping', $def->getArgument('$mapping') + $mapping)
                ->setArgument('$idMapping', $def->getArgument('$idMapping') + $idMapping)
            ;
        }

        if (!$container->has(EntityFactoryInterface::class)) {
            $container->setAlias(EntityFactoryInterface::class, new Alias('msgphp.entity_factory', false));
        }
    }

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
