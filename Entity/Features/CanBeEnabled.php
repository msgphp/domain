<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Entity\Features;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait CanBeEnabled
{
    use AbstractEnabledDisabled;

    final protected static function isDefaultEnabled(): bool
    {
        return false;
    }
}
