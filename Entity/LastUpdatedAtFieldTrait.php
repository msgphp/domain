<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Entity;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait LastUpdatedAtFieldTrait
{
    protected $lastUpdatedAt;

    public function getLastUpdatedAt(): \DateTimeInterface
    {
        return $this->lastUpdatedAt;
    }
}
