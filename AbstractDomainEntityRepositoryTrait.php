<?php

declare(strict_types=1);

namespace MsgPhp\Domain;

use MsgPhp\Domain\Exception\InvalidClassException;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait AbstractDomainEntityRepositoryTrait
{
    private $class;
    private $identityMapping;
    private $fieldMapping;

    public function __construct(string $class, DomainIdentityMappingInterface $identityMapping, array $fieldMapping = [])
    {
        $this->class = $class;
        $this->identityMapping = $identityMapping;
        $this->fieldMapping = $fieldMapping;
    }

    private function normalizeIdentifier($id, bool $normalizeObjectIdentifier = false)
    {
        if ($id instanceof DomainIdInterface) {
            return $id->isEmpty() ? null : $id;
        }

        if (is_object($id)) {
            try {
                if (!$identity = $this->identityMapping->getIdentity($id)) {
                    return null;
                }

                if (!$normalizeObjectIdentifier) {
                    return $id;
                }

                $id = array_map(function ($id) {
                    return $this->normalizeIdentifier($id, true);
                }, $identity);

                return 1 === count($id) ? reset($id) : $id;
            } catch (InvalidClassException $e) {
                return $id;
            }
        }

        return $id;
    }

    private function toIdentity($id, ...$idN): ?array
    {
        if (count($ids = func_get_args()) !== count($this->identityMapping->getIdentifierFieldNames($this->class))) {
            return null;
        }

        foreach ($ids as $id) {
            if (null === $this->normalizeIdentifier($id)) {
                return null;
            }
        }

        return array_combine($this->identityMapping->getIdentifierFieldNames($this->class), $ids);
    }

    private function isIdentity(array $fields): bool
    {
        if (count($fields) !== count($idFields = $this->identityMapping->getIdentifierFieldNames($this->class))) {
            return false;
        }

        $fields = array_map(function (string $field) {
            return $this->fieldMapping[$field] ?? $field;
        }, array_keys($fields));

        return [] === array_diff($fields, $idFields);
    }

    private function mapFields(array $fields): iterable
    {
        foreach ($fields as $key => $value) {
            yield $this->fieldMapping[$key] ?? $key => $value;
        }
    }
}
