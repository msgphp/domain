<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Entity;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait LastUpdatedAtFieldTrait
{
    private $lastUpdatedAt;

    public function getLastUpdatedAt(): \DateTime
    {
        if (null === $this->lastUpdatedAt) {
            throw new \LogicException('Update date is not set.');
        }

        return $this->lastUpdatedAt;
    }
}
