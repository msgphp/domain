<?php

declare(strict_types=1);

/*
 * This file is part of the MsgPHP package.
 *
 * (c) Roland Franssen <franssen.roland@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MsgPhp\Domain\Entity\Features;

use MsgPhp\Domain\Event\ConfirmEvent;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait CanBeConfirmed
{
    /**
     * @var string|null
     */
    private $confirmationToken;

    /**
     * @var \DateTimeInterface|null
     */
    private $confirmedAt;

    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }

    public function getConfirmedAt(): ?\DateTimeInterface
    {
        return $this->confirmedAt;
    }

    public function isConfirmed(): bool
    {
        return null !== $this->confirmedAt;
    }

    public function confirm(): void
    {
        $this->confirmationToken = null;
        $this->confirmedAt = new \DateTimeImmutable();
    }

    private function handleConfirmEvent(ConfirmEvent $event): bool
    {
        if (null === $this->confirmedAt) {
            $this->confirm();

            return true;
        }

        return false;
    }
}
