<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Infra\Doctrine\Mapping;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;

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
        $metadata = $event->getClassMetadata();

        if (in_array(CanBeEnabled::class, $metadata->getReflectionClass()->getTraitNames(), true)) {
            if ($metadata->hasField('enabled')) {
                return;
            }

            $metadata->mapField([
                'fieldName' => 'enabled',
                'type' => 'boolean',
            ]);
        }
    }
}
