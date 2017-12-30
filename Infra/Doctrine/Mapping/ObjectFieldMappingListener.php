<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Infra\Doctrine\Mapping;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class ObjectFieldMappingListener
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

    private function processFieldMapping(ClassMetadataInfo $metadata, array $fields): void
    {
        foreach ($fields as $field => $mapping) {
            if (!$metadata->hasField($field)) {
                $metadata->mapField(['fieldName' => $field] + $mapping);
            }
        }
    }

    private function processClass(ClassMetadataInfo $metadata, \ReflectionClass $class = null): void
    {
        $class = $class ?? $metadata->getReflectionClass();

        if (isset($this->mapping[$name = $class->getName()])) {
            $this->processFieldMapping($metadata, $this->mapping[$name]);
        }

        foreach ($class->getTraits() as $trait) {
            $this->processClass($metadata, $trait);
        }
    }
}
