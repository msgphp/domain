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
    private $identityMap;
    private $fieldMapping;

    public function __construct(string $class, DomainIdentityMapInterface $identityMap, array $fieldMapping = [])
    {
        $this->class = $class;
        $this->identityMap = $identityMap;
        $this->fieldMapping = $fieldMapping;
    }

    private function normalizeIdentifier($id, bool $normalizeObjectIdentifier = false)
    {
        if ($id instanceof DomainIdInterface) {
            return $id->isEmpty() ? null : $id;
        }

        if (is_object($id)) {
            try {
                if (!$identity = $this->identityMap->getIdentity($id)) {
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
        if (count($ids = func_get_args()) !== count($this->identityMap->getIdentifierFieldNames($this->class))) {
            return null;
        }

        foreach ($ids as $id) {
            if (null === $this->normalizeIdentifier($id)) {
                return null;
            }
        }

        return array_combine($this->identityMap->getIdentifierFieldNames($this->class), $ids);
    }

    private function isIdentity(array $fields): bool
    {
        if (count($fields) !== count($idFields = $this->identityMap->getIdentifierFieldNames($this->class))) {
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
