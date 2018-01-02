<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Infra\Doctrine\Mapping;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @internal
 */
final class ObjectFieldMappingListener
{
    private $mapping;

    public function __construct(array $mapping)
    {
        $this->mapping = $mapping;
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $event): void
    {
        $this->processClass($event->getClassMetadata());
    }

    private function processClass(ClassMetadataInfo $metadata, \ReflectionClass $class = null): void
    {
        $class = $class ?? $metadata->getReflectionClass();

        foreach ($class->getTraits() as $trait) {
            $this->processClass($metadata, $trait);
        }

        if (isset($this->mapping[$name = $class->getName()])) {
            $this->processFieldMapping($metadata, $this->mapping[$name]);
        }
    }

    private function processFieldMapping(ClassMetadataInfo $metadata, array $fields): void
    {
        $methods = [
            ObjectFieldMappingProviderInterface::TYPE_EMBEDDED => 'mapEmbedded',
            ObjectFieldMappingProviderInterface::TYPE_MANY_TO_MANY => 'mapManyToMany',
            ObjectFieldMappingProviderInterface::TYPE_MANY_TO_ONE => 'mapManyToOne',
            ObjectFieldMappingProviderInterface::TYPE_ONE_TO_MANY => 'mapOneToMany',
            ObjectFieldMappingProviderInterface::TYPE_ONE_TO_ONE => 'mapOneToOne',
        ];

        foreach ($fields as $field => $mapping) {
            if ($metadata->hasField($field) || $metadata->hasAssociation($field)) {
                continue;
            }

            $mapping = ['fieldName' => $field] + $mapping;

            if (!isset($mapping['type']) || !isset($methods[$mapping['type']])) {
                $metadata->mapField($mapping);
            } else {
                $method = $methods[$mapping['type']];
                unset($mapping['type']);
                $metadata->$method($mapping);
            }
        }
    }
}
