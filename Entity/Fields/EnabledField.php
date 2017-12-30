<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Entity\Fields;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait EnabledField
{
    private $enabled;

    public function isEnabled(): bool
    {
        return $this->enabled ?? ($this->enabled = static::isDefaultEnabled());
    }

    protected static function isDefaultEnabled(): bool
    {
        return false;
    }
}
