<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Infrastructure\Console\Definition;

use Symfony\Component\Console\Input\InputDefinition;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
interface DomainDefinition
{
    public function configure(InputDefinition $definition): void;
}
