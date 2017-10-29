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
        if (null === $this->lastUpdatedAt) {
            throw new \LogicException('Update date is not set.');
        }

        return $this->lastUpdatedAt;
    }
}
