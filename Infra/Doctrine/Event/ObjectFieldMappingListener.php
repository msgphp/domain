<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Infra\Doctrine\Event;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\ClassMetadataFactory;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class ObjectFieldMappingListener
{
    private $typeConfig;
    private $mapping;

    /** @var ClassMetadataFactory|null */
    private $metadataFactory;

    public function __construct(array $typeConfig, array $mapping)
    {
        $this->typeConfig = $typeConfig;
        $this->mapping = $mapping;
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $event): void
    {
        if (!$this->mapping && !$this->typeConfig) {
            return;
        }

        $this->metadataFactory = $event->getEntityManager()->getMetadataFactory();
        $metadata = $event->getClassMetadata();

        if ($this->typeConfig) {
            $this->processClassIdentifiers($metadata);
        }

        if ($this->mapping) {
            $this->processClassFields($metadata);
        }

        $this->metadataFactory = null;
    }

    private function processClassIdentifiers(ClassMetadataInfo $metadata): void
    {
        if ($metadata->usesIdGenerator()) {
            return;
        }

        foreach ($metadata->getIdentifierFieldNames() as $field) {
            if (!isset($this->typeConfig[$type = $metadata->getTypeOfField($field)]) || !in_array($this->typeConfig[$type]['type'], [Type::INTEGER, Type::BIGINT], true)) {
                continue;
            }

            $metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_AUTO);
        }
    }

    private function processClassFields(ClassMetadataInfo $metadata, \ReflectionClass $class = null): void
    {
        $class = $class ?? $metadata->getReflectionClass();

        if (isset($this->mapping[$name = $class->getName()])) {
            $this->processFieldMapping($metadata, $this->mapping[$name]);
        }

        foreach ($class->getTraits() as $trait) {
            $this->processClassFields($metadata, $trait);
        }
    }

    private function processFieldMapping(ClassMetadataInfo $metadata, array $fields): void
    {
        foreach ($fields as $field => $mapping) {
            if ($metadata->hasField($field) || $metadata->hasAssociation($field)) {
                continue;
            }

            $mapping = ['fieldName' => $field] + $mapping;

            if (isset($mapping['type']) && method_exists($metadata, $method = 'map'.ucfirst($mapping['type']))) {
                unset($mapping['type']);
                $metadata->$method($mapping);

                if ('mapEmbedded' === $method) {
                    $embeddableMetadata = $this->getMetadata($mapping['class']);

                    if ($embeddableMetadata->isEmbeddedClass) {
                        $this->addNestedEmbeddedClasses($embeddableMetadata, $metadata, $field);
                    }

                    $identifier = $embeddableMetadata->getIdentifier();

                    if (!empty($identifier)) {
                        $this->inheritIdGeneratorMapping($metadata, $embeddableMetadata);
                    }

                    $metadata->inlineEmbeddable($field, $embeddableMetadata);
                }
            } else {
                $metadata->mapField($mapping);
            }
        }
    }

    private function addNestedEmbeddedClasses(ClassMetadataInfo $subClass, ClassMetadataInfo $parentClass, string $prefix): void
    {
        foreach ($subClass->embeddedClasses as $property => $embeddableClass) {
            if (isset($embeddableClass['inherited'])) {
                continue;
            }

            $embeddableMetadata = $this->getMetadata($embeddableClass['class']);

            $parentClass->mapEmbedded([
                'fieldName' => $prefix.'.'.$property,
                'class' => $embeddableMetadata->name,
                'columnPrefix' => $embeddableClass['columnPrefix'],
                'declaredField' => $embeddableClass['declaredField'] ? $prefix.'.'.$embeddableClass['declaredField'] : $prefix,
                'originalField' => $embeddableClass['originalField'] ?: $property,
            ]);
        }
    }

    private function inheritIdGeneratorMapping(ClassMetadataInfo $class, ClassMetadataInfo $parent): void
    {
        if ($parent->isIdGeneratorSequence()) {
            $class->setSequenceGeneratorDefinition($parent->sequenceGeneratorDefinition);
        } elseif ($parent->isIdGeneratorTable()) {
            $class->tableGeneratorDefinition = $parent->tableGeneratorDefinition;
        }

        if ($parent->generatorType) {
            $class->setIdGeneratorType($parent->generatorType);
        }

        if ($parent->idGenerator) {
            $class->setIdGenerator($parent->idGenerator);
        }
    }

    private function getMetadata(string $class): ClassMetadataInfo
    {
        if (null === $this->metadataFactory) {
            throw new \LogicException('Metadata factory not set.');
        }

        $loaded = $this->metadataFactory->getLoadedMetadata();

        /** @var ClassMetadataInfo $metadata */
        $metadata = $loaded[$class] ?? $this->metadataFactory->getMetadataFor($class);

        return $metadata;
    }
}
