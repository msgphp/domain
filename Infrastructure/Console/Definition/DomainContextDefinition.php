<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Infrastructure\Console\Definition;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Style\StyleInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
interface DomainContextDefinition extends DomainDefinition
{
    public function getContext(InputInterface $input, StyleInterface $io, array $values = []): array;
}
