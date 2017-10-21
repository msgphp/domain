<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Infra\Doctrine;

use MsgPhp\Domain\Infra\Uuid\DomainId;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class DomainUuidType extends Type
{
    public function getName(): string
    {
        return str_replace('\\', '_', get_class($this));
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (!is_string($value)) {
            throw ConversionException::conversionFailed($value, $this->getName());
        }

        try {
            return $this->convertToDomainId($value);
        } catch (InvalidUuidStringException $e) {
            throw ConversionException::conversionFailed($value, $this->getName());
        }
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (is_string($value)) {
            return $value;
        }

        if ($value instanceof DomainId) {
            return $value->toString();
        }

        throw ConversionException::conversionFailed($value, $this->getName());
    }

    protected function convertToDomainId(string $value): DomainId
    {
        return new DomainId($value);
    }
}
