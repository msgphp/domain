<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Entity;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait CreatedAtFieldTrait
{
    private $createdAt;

    public function getCreatedAt(): \DateTimeInterface
    {
        if (null === $this->createdAt) {
            throw new \LogicException('Creation date is not set.');
        }

        return $this->createdAt;
    }
}
