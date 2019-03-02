<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Tests\Fixtures;

use MsgPhp\Domain\DomainIdInterface;
use MsgPhp\Domain\DomainIdTrait;

final class TestDomainId implements DomainIdInterface
{
    use DomainIdTrait;
}
