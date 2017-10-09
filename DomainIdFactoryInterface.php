<?php

declare(strict_types=1);

namespace MsgPhp\Domain;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
interface DomainIdFactoryInterface
{
    public function identify(string $entity, $id): DomainIdInterface;
    public function nextIdentity(string $entity): DomainIdInterface;
}
