<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Infra\Doctrine;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\MappingException;
use MsgPhp\Domain\DomainIdentityMapInterface;
use MsgPhp\Domain\Exception\InvalidClassException;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class DomainIdentityMap implements DomainIdentityMapInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getIdentifierFieldNames(string $class): array
    {
        return $this->getMetadata($class)->getIdentifierFieldNames();
    }

    public function getIdentity($entity): array
    {
        return $this->getMetadata(get_class($entity))->getIdentifierValues($entity);
    }

    private function getMetadata(string $class): ClassMetadata
    {
        try {
            return $this->em->getMetadataFactory()->getMetadataFor($class);
        } catch (MappingException $e) {
            throw InvalidClassException::create($class);
        }
    }
}
