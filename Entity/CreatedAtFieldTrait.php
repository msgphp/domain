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
        return $this->createdAt;
    }
}
